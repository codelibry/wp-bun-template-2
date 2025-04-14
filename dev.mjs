import path from 'path';
import * as sass from 'sass';
import fs from 'fs';
import browserSync from 'browser-sync';
import { Bundler } from 'bun-bundler';
// import { Bundler } from 'bun-bundler/modules';
// import { Server, Bundler } from 'bun-bundler/modules';

function getProjectFolderName() {
	const currentDir = process.cwd();
	const folderName = path.basename(currentDir);
	return folderName;
}

const PROJECT_FOLDER = getProjectFolderName();

const debugMode = false;
const bundler = new Bundler();

const root = path.resolve('./');
const src = path.resolve('./src');
const dist = path.resolve('./dist');

const directories = {
	src: src,

	sass: [path.resolve(src, './scss/app.scss')],
	js: [path.resolve(src, './js/app.js')],
	images: path.resolve(src, './images/'),
	fonts: path.resolve(root, 'assets/fonts/'),
	statics: path.resolve(src, './static/'),

	dist: dist,
	htmlDist: dist,
	cssDist: path.resolve(dist, './css/'),
	jsDist: path.resolve(dist, './js/'),
	imagesDist: path.resolve(dist, './images/'),
	spriteDist: path.resolve(dist, './images/sprite'),
};

bundler.watch({
	...directories,
	production: process.env.NODE_ENV === 'production',
	debug: debugMode,

	onStart: () => {
		browserSync.init({
			proxy: 'http://template-v2/',
			port: 3000,
			injectChanges: true,
			files: [
				`${dist}/css/*.css`,
				`${root}/**/*.php`,
				`${src}/js/**/*.js`,
				// `${src}/**/*`,
				`!${root}/node_modules/**/*`,
				`!${root}/helpers/**/*`,
			],
			open: true,
			notify: false,
			ghostMode: false,
			reloadDebounce: 100,
			// reloadOnRestart: true, // Перезагрузка при перезапуске
		});
	},
	onBuildComplete: () => {
		const criticalPath = path.resolve(src, './scss/critical/critical.scss');
		if (fs.existsSync(criticalPath)) {
			const result = sass.compile(criticalPath, { style: 'compressed', quietDeps: true });
			fs.writeFileSync(path.join(`${dist}/css/`, 'critical.css'), result.css);
		}
	},
	onCriticalError: () => {
		server.stopServer();
	},
});
