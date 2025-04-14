<?php
/*
 * Block: Video
 */

$label = get_sub_field('video_label');
$title = get_sub_field('video_title');
$descr = get_sub_field('video_descr');
$poster = get_sub_field('video_poster');
$video_source = get_sub_field('video_source');
$video = get_sub_field('video_video');

$button_1 = get_sub_field('button_primary');
$button_2 = get_sub_field('button_secondary');

$youtube_id = get_sub_field('youtube_id') ?? '';
$vimeo_id = get_sub_field('vimeo_id') ?? '';

$id = get_sub_field('block-options');
$bg = get_sub_field('background_settings');
$bg_color = "";

if ($bg['background_color']) {
	$bg_color = 'style=' . 'background-color:' . $bg['background_color'];
}

if ($poster && isset($poster['url'])) {
	$poster_url = set_url_scheme($poster['url']);
} else {
	$poster_url = '';
}

if (!$video && !$youtube_id && !$vimeo_id) {
	return get_template_part('template-parts/error/invalid-block', '', [
		'title' => 'Video is missing'
	]);
}

?>

<section id="<?php echo $id ? $id['block_id'] : ''; ?>" class="video section js-video-w <?php echo $bg['text_color']; ?>" <?php echo $bg_color; ?>>
	<?php
	if ($bg['background_image']) { ?>
		<picture class="section_global_bg_img">
			<img <?php acf_image_attrs($bg['background_image']) ?>>
		</picture>
	<?php }; ?>

	<div class="section_in <?php echo $bg['background_image'] ? 'container-relative' : '' ?>">
		<?php if ($label || $title || $descr) { ?>
			<div class="video__player_heading">
				<?php render_heading_block($label, $title, $descr); ?>
			</div>
		<?php }; ?>
		<?php if ($button_1 || $button_2) { ?>
			<?php render_buttons_block($button_1, $button_2, 'video__button_w'); ?>
		<?php }; ?>
		<div class="video__player_w">
			<?php
			if ($video_source == 'video-youtube' && $youtube_id) {
			?>
				<div id="player" class="video_block" data-plyr-provider="youtube" data-plyr-embed-id="<?php echo esc_attr($youtube_id); ?>"></div>
			<?php
			} else if ($video_source == 'video-vimeo' && $vimeo_id) {
			?>
				<div id="player" class="video_block" data-plyr-provider="vimeo" data-plyr-embed-id="<?php echo esc_attr($vimeo_id); ?>"></div>
			<?php
			} else if ($video) {
			?>
				<video class="video_block" id="player" playsinline controls
					<?php if ($poster_url) { ?>
					data-poster="<?php echo esc_url($poster_url); ?>"
					<?php } ?>>
					<source src="<?php echo esc_url($video); ?>" type="video/mp4" />
				</video>
			<?php
			}
			?>
		</div>
	</div>
</section>