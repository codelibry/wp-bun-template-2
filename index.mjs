/* eslint-disable prefer-template */
import Bun from 'bun';
import path, { basename, extname, resolve } from 'path';
import fsPromises from 'fs/promises';
import fs, { existsSync, readFileSync, writeFileSync } from 'fs';
import {
	createDir,
	exec,
	getDirFiles,
	getFilesList,
	removeDir,
	moveFile,
	createFile,
	removeFile,
} from './utils.mjs';
import { Reporter } from './modules/reporter';
import { constants } from './modules/constants';

const sass = require('sass');

export class Bundler extends Reporter {
	constructor() {
		super();

		this.watchDebounce = null;
		this.config = {
			rootDir: process.cwd(),
		};
	}

	writeDistFiles(dist, compiledData) {
		Object.values(compiledData).forEach(({ fileContent, fileName } = {}) => {
			if (!fileContent === null) return;
			writeFileSync(path.join(dist, fileName), fileContent);
		});
	}

	async compile({ filePaths, type, renderFn, newFileExt, dist, skipExtensions = [] }) {
		if (!Array.isArray(filePaths) || !filePaths.length) {
			this.errThrow(`${type} - No files to compile`);
		}

		const compiledData = await Promise.all(
			filePaths.map(async (filePath) => {
				if (!existsSync(filePath)) {
					this.errThrow(`${type} compilation: File ${filePath} doesn't exist`);
				}
				const fileExtname = extname(filePath);
				let fileName = basename(filePath);
				if (newFileExt) fileName = fileName.replace(path.extname(filePath), newFileExt);

				const res = {
					fileName,
					path: filePath,
				};

				if (skipExtensions && skipExtensions.includes(fileExtname)) {
					res.fileContent = readFileSync(filePath, 'utf-8');
				} else {
					res.fileContent = renderFn(filePath, fileExtname);
				}

				return res;
			}),
		);

		if (constants.compilationTypes.css === type && this.config.assembleStyles) {
			this.stylesToAssemble = compiledData;
			return;
		}

		this.writeDistFiles(dist, compiledData);
	}

	// assemble all comppiled files into one file
	async assembleStyles() {
		if (!this.config.assembleStyles) return;

		this.debugLog('Styles assembling');
		const distFileURL = path.resolve(this.config.assembleStyles);
		let distFileContent = '';

		const injectFileContent = (content, fileName) => {
			distFileContent += `\n\n/* @${fileName} */\n`;
			distFileContent += content;
		};

		this.importedStylesToAssemble?.forEach(({ fileContent, fileName, fileURL }) => {
			if (!fileContent) return;
			injectFileContent(fileContent, fileName);
			removeFile(fileURL);
		});

		this.stylesToAssemble?.forEach(({ fileContent, fileName }) => {
			if (!fileContent) return;
			injectFileContent(fileContent, fileName);
		});

		createFile({ url: distFileURL, content: distFileContent });

		await this.compile({
			filePaths: [distFileURL],
			type: constants.compilationTypes.css,
			newFileExt: constants.extDist.css,
			dist: distFileURL,
			renderFn: (filePath) =>
				sass.compile(filePath, {
					style: 'compressed',
					noWarn: true,
					quietDeps: true,
					...this.config.sassConfigOverrides,
				})?.css,
		});
	}

	async compileStyles() {
		this.stylesToAssemble = [];
		this.debugLog('Styles compilation');
		createDir(this.config.cssDist);

		try {
			// Компиляция основных стилей (без critical.scss)
			const filesToCompile = this.config.sassFiles.filter((file) => !file.includes('critical.scss'));
			await this.compile({
				filePaths: filesToCompile,
				type: constants.compilationTypes.css,
				newFileExt: constants.extDist.css,
				dist: this.config.cssDist,
				renderFn: (filePath) =>
					sass.compile(filePath, {
						style: 'compressed',
						noWarn: true,
						quietDeps: true,
						...this.config.sassConfigOverrides,
					})?.css,
			});

			// Компиляция критического стиля отдельно
			const criticalCssFile = this.config.sassFiles.find((file) => file.includes('critical.scss'));

			if (criticalCssFile) {
				const criticalCssContent = sass.compile(criticalCssFile, {
					style: 'compressed',
					noWarn: true,
					quietDeps: true,
					...this.config.sassConfigOverrides,
				})?.css;

				// Записываем скомпилированный critical.css в отдельный файл
				createFile({ url: path.join(this.config.cssDist, 'critical.css'), content: criticalCssContent });
			}
		} catch (error) {
			this.errLog('Error while compiling css/scss files');
			this.errThrow(error);
		}
	}

	async compileScripts() {
		this.debugLog('Scripts compilation');
		this.importedStylesToAssemble = [];
		createDir(this.config.jsDist);

		try {
			const result = await Bun.build({
				entrypoints: this.config.jsFiles,
				outdir: this.config.jsDist,
				minify: this.config.production,
				format: 'esm',
				...this.config.jsConfigOverrides,
			});

			if (!result.success) {
				result?.logs?.forEach((message) => {
					this.errLog(message);
				});
				this.errThrow();
			}

			const importedCSS = result.outputs.filter(
				(output) => path.extname(output.path) === constants.extDist.css,
			);

			if (importedCSS.length && this.config.cssDist && !this.config.assembleStyles) {
				importedCSS.forEach((asset) => {
					const cssModules = path.join(this.config.cssDist, './modules');
					createDir(cssModules);
					moveFile(asset.path, cssModules);
				});
			}

			if (this.config.assembleStyles) {
				this.debugLog('Assembling styles');
				this.importedStylesToAssemble = importedCSS.map((asset) => ({
					fileContent: readFileSync(asset.path, 'utf-8'),
					fileName: path.basename(asset.path),
					fileURL: asset.path,
				}));
			}
		} catch (error) {
			this.errLog('Error while compiling js files');
			this.errThrow(error);
		}
	}

	isFileChangedDuringWatch({ extname, folder, isWatchMode }) {
		if (!isWatchMode) return true;

		const changedFiles = Object.keys(this.watchChangedFileList);
		const changedExt = Object.keys(this.watchChangedExtList);

		if (!changedFiles?.length) return false;

		if (extname?.length && changedExt.find((fileExt) => extname.includes(fileExt))) return true;

		if (
			folder?.length &&
			changedFiles.find((filePath) =>
				folder.find((folderPath) => path.resolve(filePath).startsWith(path.resolve(folderPath))),
			)
		) {
			return true;
		} else return false;
	}

	setConfig(cfg, mode) {
		if (!cfg) this.errThrow('Config is not defined');
		if (!cfg.dist) this.errThrow('Dist directory is not defined');

		const {
			dist = [],
			sass = [],
			js = [],
			cssDist = '',
			jsDist = '',
			jsConfigOverrides = {},
			sassConfigOverrides = {},
			assembleStyles,
		} = cfg;

		if (!this.config.initialCfg) this.config.initialCfg = cfg;

		this.config.production = cfg.production;

		this.config.sassFiles = [exec(sass)].flat();
		this.config.jsFiles = [exec(js)].flat();

		this.config.watchDir = resolve(this.config.rootDir, cfg.watchDir || './src/');
		this.config.distDir = resolve(this.config.rootDir, dist || './dist/');
		this.config.cssDist = resolve(this.config.rootDir, cssDist || this.config.distDir + './css/');
		this.config.jsDist = resolve(this.config.rootDir, jsDist || this.config.distDir + './js/');

		this.config.onStart = cfg.onStart;
		this.config.onBuildComplete = cfg.onBuildComplete;
		this.config.onCriticalError = cfg.onCriticalError;
		this.config.debug = cfg.debug;
		this.config.refresh = () => {
			this.setConfig(this.config.initialCfg, mode);
		};

		this.config.assembleStyles = assembleStyles;
		this.config.jsConfigOverrides = jsConfigOverrides;
		this.config.sassConfigOverrides = {
			...(getSassFileConfig.call(this, this.config.rootDir) || {}),
			...sassConfigOverrides,
		};

		if (mode === 'watch') {
			if (!this.config.watchDir) {
				exec(this.config.onCriticalError);
				this.errThrow('Can`t resolve watch directory.');
			}
		}
	}

	async bundle({ onBuildComplete, mode } = {}) {
		try {
			const isWatchMode = mode === 'watch';

			if (isWatchMode) {
				this.log('\n');
				this.log('[⏳ Refreshing... ]');
			} else {
				this.log('\n');
				this.log('[✨ Starting... ]');
			}
			const start = Date.now();

			if (!isWatchMode) {
				this.debugLog('Clearing old dist.');
				removeDir(this.config.distDir);
				createDir(this.config.distDir);
			}

			const needCompile = ({ extname, folder }) => {
				if (this.isFileChangedDuringWatch({ extname, folder, isWatchMode })) return true;
			};

			const { styles, scripts } = constants.extensions;

			const modulesToCompile = {
				styles: needCompile({ extname: styles }),
				scripts: needCompile({ extname: scripts }),
			};

			if (modulesToCompile.styles) await this.compileStyles();
			if (modulesToCompile.scripts) await this.compileScripts();
			if ((modulesToCompile.scripts || modulesToCompile.styles) && this.config.assembleStyles)
				await this.assembleStyles();

			const end = Date.now();
			this.log(`[✅ Done ${end - start}ms ]`);

			exec(onBuildComplete);
		} catch (error) {
			this.errLog(error.message);
		}
	}

	build(cfg) {
		this.setConfig(cfg);
		exec(this.config.onStart);
		this.bundle({
			mode: 'build',
			onBuildComplete: () => exec(this.config.onBuildComplete),
		});
	}

	watchBuild() {
		this.config.refresh();

		this.bundle({
			mode: 'watch',
			onBuildComplete: () => {
				this.watchChangedFileList = {};
				this.watchChangedExtList = {};
			},
		});
		exec(this.config.onWatchUpdate);
	}

	unwatch() {
		if (this.watcher) {
			this.watcher.close();
			this.watcher = null;
		}
	}

	registerWatchFileChanged(fileUrl) {
		const extName = path.extname(fileUrl);
		if (!extName) return;

		this.watchChangedFileList[fileUrl] = true;
		this.watchChangedExtList[extName] = true;
	}

	handleWatchChangeFile(fileUrl, reloadInterval) {
		const interval = typeof reloadInterval === 'number' && reloadInterval >= 0 ? reloadInterval : 300;
		clearTimeout(this.watchDebounce);
		this.registerWatchFileChanged(fileUrl);
		this.watchDebounce = setTimeout(this.watchBuild.bind(this), interval);
	}

	watch(cfg) {
		try {
			this.setConfig(cfg, 'watch');
			exec(this.config.onStart);

			this.watchChangedFileList = {};
			this.watchChangedExtList = {};

			if (!fs.existsSync(this.config.watchDir)) {
				exec(this.config.onCriticalError);
				return this.errThrow('Can`t resolve watch directory.');
			}

			this.unwatch();
			this.watcher = fs.watch(this.config.watchDir, { recursive: true }, (eventType, fileName) => {
				this.debugLog(eventType);
				const fileUrl = path.resolve(this.config.watchDir, fileName);
				this.handleWatchChangeFile(fileUrl, eventType === 'rename' && 100);
			});
			this.bundle({
				onBuildComplete: () => exec(this.config.onBuildComplete),
			});
		} catch (error) {
			this.errLog(error.message);
		}
		return null;
	}
}

Bundler.utils = {
	getDirFiles,
	getFilesList,
};

export default Bundler;
