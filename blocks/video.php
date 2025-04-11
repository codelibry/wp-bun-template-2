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

$youtube_id = get_sub_field('youtube_id') ?? '';
$vimeo_id = get_sub_field('vimeo_id') ?? '';

$id = get_sub_field('block-options');
$bg = get_sub_field('duplex_2_bg');

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

<section id="<?php echo $id ? $id['block_id'] : ''; ?>" class="video section js-video-w <?php echo $bg; ?>">
	<div class="section_in">
		<?php if ($label || $title || $descr) { ?>
			<?php render_heading_block($label, $title, $descr); ?>
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