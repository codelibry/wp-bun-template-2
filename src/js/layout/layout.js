import { calcViewportHeight, onWindowResize } from '../utils';
import header from '../../js/components/header';

const layout = () => {
	onWindowResize(() => {
		calcViewportHeight();
	});
	calcViewportHeight();
	header();
};

export default layout;
