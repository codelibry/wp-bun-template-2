<?php

$list = get_field('ui-color-list');
?>

<section class="ui_colors section">
	<div class="section_in">
		<h2 class="heading-2 ui_title">
			Colors
		</h2>
		<?php if ($list) { ?>
			<div class="ui_colors__list">
				<?php foreach ($list as $item) {
					$color = $item['color'];
					$name = $item['name'];
				?>
					<div class="ui_colors__item">
						<div class="ui_colors__block" style="background: <?php echo $color; ?>"></div>
						<div class="ui_colors__descr"><?php echo $color; ?></div>
						<?php if ($name) { ?>
							<div class="ui_colors__descr"><?php echo $name; ?></div>
						<?php }; ?>
					</div>
				<?php }; ?>
			</div>
		<?php }; ?>

	</div>
</section>