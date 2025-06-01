<?php
/*
 * Block: Duplex 1
 */

$section_title = get_sub_field('duplex_1_section_title');
$title = get_sub_field('duplex_1_title');
$descr = get_sub_field('duplex_1_descr');
$image = get_sub_field('duplex_1_image');

$position = get_sub_field('content_position');
$settings = get_sub_field('media_settings');

$video_group_settings = get_sub_field('duplex_1_video_source_group');

$poster = $video_group_settings['poster'] ?? false;
$video_source = $video_group_settings['source'] ?? '';
$video_url = $video_group_settings['video_url'] ?? '';
$youtube_id = $video_group_settings['youtube_id'] ?? '';
$vimeo_id = $video_group_settings['vimeo_id'] ?? '';

$button_1 = get_sub_field('button_primary');
$button_2 = get_sub_field('button_secondary');

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
?>

<section id="<?php echo $id ? $id['block_id'] : ''; ?>" class="duplex_1 section <?php echo $position; ?> <?php echo $bg['text_color']; ?>" <?php echo $bg_color; ?>>
	<?php if ($bg['background_image']) { ?>
		<picture class="section_global_bg_img">
			<img <?php acf_image_attrs($bg['background_image']) ?>>
		</picture>
	<?php }; ?>

	<div class="section_in duplex_1__in">
		<?php if ($section_title) { ?>
			<div class="duplex_1__heding">
				<?php render_heading_block(false, $section_title, false); ?>
			</div>
		<?php }; ?>
		<div class="row duplex_1__row">
			<div class="col-lg-6 duplex_1__col_info">
				<div class="duplex_1__info">
					<?php if ($title) { ?>
						<h2 class="duplex_1__title"><?php echo $title; ?></h2>
					<?php }; ?>
					<?php if ($descr) { ?>
						<div class="duplex_1__descr article-block"><?php echo $descr; ?></div>
					<?php }; ?>
					<?php if ($button_1 || $button_2) { ?>
						<?php echo render_buttons_block($button_1, $button_2) ?>
					<?php }; ?>
				</div>
			</div>
			<?php if ($image || $settings == 'media--video') { ?>
				<div class="col-lg-6 duplex_1__col_image">
					<?php if ($settings == 'media--image') { ?>
						<div class="duplex_1__image_box">
							<picture class="duplex_1__image">
								<?php echo wp_get_attachment_image($image["ID"], 'large', false); ?>
							</picture>
						</div>
					<?php }; ?>
					<?php if ($settings == 'media--video') { ?>
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
							} else if ($video_url) {
							?>
								<video class="video_block" id="player" playsinline controls
									<?php if ($poster_url) { ?>
									data-poster="<?php echo esc_url($poster_url); ?>"
									<?php } ?>>
									<source src="<?php echo esc_url($video_url); ?>" type="video/mp4" />
								</video>
							<?php }; ?>
						</div>
					<?php }; ?>
				</div>
			<?php }; ?>
		</div>
	</div>
</section>