import layout from './layout/layout';
import { documentReady, pageLoad } from './utils';

window.NodeList.prototype.map = Array.prototype.map;
window.NodeList.prototype.filter = Array.prototype.filter;

const app = () => {
	layout();
	pageLoad(() => {
		document.body.classList.add('body--loaded');
	});
};

// -------------------  init App
documentReady(() => {
	app();
});
// -------------------  init App##
