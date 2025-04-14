<?php
/*
 * Block: FAQ
 */

$label = get_sub_field('faq__label');
$title = get_sub_field('faq__title');
$descr = get_sub_field('faq__description');
$faqs = get_sub_field('faq__list');
$id = get_sub_field('block-options');

$button_1 = get_sub_field('button_primary');
$button_2 = get_sub_field('button_secondary');

$bg = get_sub_field('background_settings');
$bg_color = "";

if ($bg['background_color']) {
	$bg_color = 'style=' . 'background-color:' . $bg['background_color'];
}
?>

<section id="<?php echo $id ? $id['block_id'] : ''; ?>" class="faq section <?php echo $bg['text_color']; ?>" <?php echo $bg_color; ?>>
	<?php
	if ($bg['background_image']) { ?>
		<picture class="section_global_bg_img">
			<img <?php acf_image_attrs($bg['background_image']) ?>>
		</picture>
	<?php }; ?>

	<div class="section_in faq__in container-relative">
		<?php if ($title || $label || $descr) { ?>
			<div class="faq__heading">
				<?php render_heading_block($label, $title, $descr) ?>
			</div>
		<?php } ?>
		<?php if ($button_1 || $button_2) { ?>
			<?php render_buttons_block($button_1, $button_2, 'faq__button_w'); ?>
		<?php }; ?>

		<div class="faq__list">
			<?php foreach ($faqs as $key => $faq):
				$item_title = $faq['title'];
				$item_descr = $faq['content'];
			?>
				<div class="faq__item_w">
					<div class="faq__item">
						<div class="faq__item_head js-accordion">
							<h6 class="faq__item_title">
								<?php echo $item_title; ?>
							</h6>
							<div class="faq__item_icon_w">+</div>
						</div>
						<div class="faq__item_body">
							<div class="faq__item_body_in">
								<?php echo $item_descr; ?>
							</div>
						</div>
					</div>
				</div>
			<?php
			endforeach; ?>
		</div>
	</div>
</section>