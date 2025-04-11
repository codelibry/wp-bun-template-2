const video = () => {
	const THEME_NAME = window.codelibry?.theme_name || 'default-theme';

	const loadLargeCSS = () => {
		const cssPath = `/wp-content/themes/${THEME_NAME}/assets/css/plyr.css`;

		if (!document.querySelector(`link[href="${cssPath}"]`)) {
			const link = document.createElement('link');
			link.rel = 'stylesheet';
			link.href = cssPath;
			document.head.appendChild(link);
		}
	};

	if (!document.querySelector('.video_block')) return;
	if (document.querySelector('script[src*="plyr.js"]')) return;

	loadLargeCSS();

	const script = document.createElement('script');
	script.src = `/wp-content/themes/${THEME_NAME}/assets/js/plyr.js`;
	script.defer = true;
	script.onload = () => initVideo();
	document.body.appendChild(script);
};

const initVideo = () => {
	const videoBlocks = document.querySelectorAll('.video_block');
	if (videoBlocks.length === 0) return;

	const videoPlayer = Array.from(videoBlocks).map(
		(p) =>
			new Plyr(p, {
				iconUrl: 'https://cdn.plyr.io/3.7.8/plyr.svg',
				invertTime: false,
				hideControls: true,
			}),
	);

	videoPlayer.forEach((item) =>
		item.on('play', () => {
			item.toggleControls(true);
			videoPlayer.forEach((itemA) => {
				if (itemA !== item) {
					itemA.stop();
				}
			});
		}),
	);

	videoPlayer.forEach((item) =>
		item.on('pause ready', () => {
			item.toggleControls(false);
		}),
	);
};

export default video;
