<?php

function render_heading_block($label = false, $title = false, $descr = false, $mod = '')
{

	if ($label || $title || $descr) {
?>
		<div class="heading-block <?php echo esc_html($mod); ?>">
			<?php if (!empty($label)) { ?>
				<div class="heading_block__label"><?php echo esc_html($label); ?></div>
			<?php }; ?>

			<?php if (!empty($title)) { ?>
				<h2 class="heading_block__title"><?php echo esc_html($title); ?></h2>
			<?php }; ?>

			<?php if (!empty($descr)) { ?>
				<div class="heading_block__descr article_block"><?php echo $descr; ?></div>
			<?php }; ?>
		</div>
<?php
	}
}
