import path from 'path';
import * as sass from 'sass';
import fs from 'fs';
import { Bundler } from 'bun-bundler';

const bundler = new Bundler();

const src = path.resolve('./src');
const dist = path.resolve('./build');

const directories = {
	src: src,

	sass: [path.resolve(src, './scss/app.scss')],
	js: [path.resolve(src, './js/app.js')],
	// statics: path.resolve(src, './static/'),
	dist: dist,

	cssDist: path.resolve(dist, './css/'),
	jsDist: path.resolve(dist, './js/'),
};

const { jsDist } = directories;

bundler.build({
	...directories,
	production: true,

	onBuildComplete: () => {
		const criticalPath = path.resolve(src, './scss/critical/critical.scss');
		if (fs.existsSync(criticalPath)) {
			const result = sass.compile(criticalPath, { style: 'compressed' });
			fs.writeFileSync(path.join(directories.cssDist, 'critical.css'), result.css);
		}
	},
});
