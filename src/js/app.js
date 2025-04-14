import video from './components/video';
import defoultSlider from './components/default-slider';
import initPopup from './components/init-popup';
import Accordion from './components/accordion';
import tabs from './components/tabs';

import layout from './layout/layout';
import { documentReady, pageLoad } from './utils';

window.NodeList.prototype.map = Array.prototype.map;
window.NodeList.prototype.filter = Array.prototype.filter;

const app = () => {
	layout();
	pageLoad(() => {
		document.body.classList.add('body--loaded');

		const accordion = Accordion({
			triggers: document.querySelectorAll('.js-accordion'),
			activeStateName: 'active-mod',
		});

		const subMenu = Accordion({
			triggers: document.querySelectorAll('.mobile_menu__list .menu-item__parent'),
			activeStateName: 'active-mod',
		});

		tabs({
			wrapper: '.js-product-tab',
			trigger: '.js-product-tab-trigger',
			content: '.js-product-tab-content',
			triggerClass: 'tab_nav_item',
			contentClass: 'tab_content',
		});

		initPopup('.js-popup-trigger-info', '.js-popup-info');
		initPopup('.js-popup-trigger-info2', '.js-popup-info2');

		defoultSlider();
		video();
	});
};

// -------------------  init App
documentReady(() => {
	app();
});
// -------------------  init App##
