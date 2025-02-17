import path from 'path';
import * as sass from 'sass';
import fs from 'fs';
import browserSync from 'browser-sync';
// import { Bundler } from 'bun-bundler/modules';
import { Server, Bundler } from 'bun-bundler/modules';

const debugMode = false;
const bundler = new Bundler();
const server = new Server();

const root = path.resolve('./');
const dist = path.resolve('./dist');
const src = path.resolve('./src');

bundler.watch({
	production: process.env.NODE_ENV === 'production',
	debug: debugMode,
	sass: [`${src}/scss/app.scss`, `${src}/scss/critical/critical.scss`],
	js: [`${src}/js/app.js`],
	staticFolders: [`${src}/images/`, `${src}/fonts/`, `${src}/static/`],
	dist,
	htmlDir: dist,
	cssDist: `${dist}/css/`,
	assembleStyles: `${dist}/css/app.css`,
	jsDist: `${dist}/js/`,
	onStart: () => {
		browserSync.init({
			proxy: 'http://template-v2/',
			port: 3000,
			// reloadDebounce: 500,
			files: [
				`${root}/**/*.php`,
				`${src}/**/*.js`,
				`${src}/**/*`,
				`!${root}/node_modules/**/*`,
				`!${dist}/**/*`,
				`!${root}/helpers/**/*`,
			],
			open: true,
			notify: false,
			ghostMode: false,
			// reloadOnRestart: true, // Перезагрузка при перезапуске
		});
	},
	onBuildComplete: () => {
		const criticalPath = path.resolve(src, './scss/critical/critical.scss');
		if (fs.existsSync(criticalPath)) {
			const result = sass.compile(criticalPath, { style: 'compressed' });
			fs.writeFileSync(path.join(`${dist}/css/`, 'critical.css'), result.css);
		}
	},
	onCriticalError: () => {
		server.stopServer();
	},
});
