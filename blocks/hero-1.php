<?php
/*
 * Block: Hero 1
 */

$label = get_sub_field('hero_1_label');
$title = get_sub_field('hero_1_title');
$descr = get_sub_field('hero_1_descr');
$video = get_sub_field('hero_1_video');
$button_1 = get_sub_field('button_primary');
$button_2 = get_sub_field('button_secondary');

$id = get_sub_field('block-options');
$bg = get_sub_field('background_settings');
$bg_color = "";

if ($bg['background_color']) {
	$bg_color = 'style=' . 'background-color:' . $bg['background_color'];
}

?>

<section id="<?php echo $id ? $id['block_id'] : ''; ?>" class="hero_1 section js-hero_1-w <?php echo $bg['text_color']; ?>" <?php echo $bg_color; ?>>
	<?php if ($video) { ?>
		<video class="hero_1_video" autoplay muted loop>
			<source src="<?php echo esc_url($video); ?>" type="video/mp4" />
		</video>
	<?php }; ?>

	<?php
	if ($bg['background_image']) { ?>
		<picture class="section_global_bg_img">
			<img <?php acf_image_attrs($bg['background_image']) ?>>
		</picture>
	<?php }; ?>

	<div class="section_in container-relative">
		<?php if ($label || $title || $descr) { ?>
			<div class="hero_1__heading_w">
				<?php render_heading_block($label, $title, $descr, 'hero_1__heading'); ?>
			</div>
		<?php }; ?>
		<?php if ($button_1 || $button_2) { ?>
			<?php render_buttons_block($button_1, $button_2, 'hero_1__button_w'); ?>
		<?php }; ?>
	</div>
</section>