import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
// import 'swiper/scss/scrollbar';
import { buildSwiper, removeSwiper } from './build-swiper';

const CLASS_NAMES = {
	slider: '.js-default-slider',
	wrapper: '.js-default-slider-wrapper',
	arrowNext: '.js-default-nav-next',
	arrowPrev: '.js-default-nav-prev',
	pagination: '.js-default-pagination',
};

Swiper.use([Navigation, Pagination]);

/**
 * Swiper default sample
 */
const defaultSlider = () => {
	const $sliderWrappers = document.querySelectorAll(CLASS_NAMES.wrapper);

	if (!$sliderWrappers.length) return;

	$sliderWrappers.forEach(($wrapper) => {
		const $slider = $wrapper.querySelector(CLASS_NAMES.slider);
		const $prevArrow = $wrapper.querySelector(CLASS_NAMES.arrowPrev);
		const $nextArrow = $wrapper.querySelector(CLASS_NAMES.arrowNext);
		const $pagination = $wrapper.querySelector(CLASS_NAMES.pagination);

		buildSwiper($slider);

		const sliderInstance = new Swiper($slider, {
			observer: true,
			observeParents: true,
			speed: 800,
			// loop: true,
			navigation: {
				prevEl: $prevArrow,
				nextEl: $nextArrow,
			},
			pagination: {
				el: $pagination,
				type: 'bullets',
				clickable: true,
			},

			breakpoints: {
				320: {
					slidesPerView: 1,
				},
				1023: {
					slidesPerView: 3,
					spaceBetween: 20,
				},
			},
		});
	});
};

export default defaultSlider;
