<?php

$list = get_field('ui-typography-list');
?>

<section class="ui_typography section">
	<div class="section_in">
		<h2 class="heading-2 ui_title">
			02 Typography
		</h2>

		<h3 class="heading-3 ui_sub_title">
			Fonts
		</h3>
		<?php if ($list) { ?>
			<div class="ui_typography__font">
				<?php foreach ($list as $item) {
					$font = $item['font_name'];
					$weights = $item['weihgts_list'];
				?>
					<div class="ui_typography__font_item">
						<div class="ui_typography__font_block" style="font-family: <?php echo $font; ?>">Aa</div>
						<div class="ui_typography__font_name"><?php echo $font; ?></div>
						<?php if ($weights) { ?>

							<div class="ui_typography__font_weights">
								<div class="ui_typography__font_weights_item">Weihgts:</div>
								<?php
								foreach ($weights as $weight) {
								?>
									<div class="ui_typography__font_weights_item"><?php echo $weight['font_weights']; ?>,</div>
								<?php }; ?>
							</div>
						<?php }; ?>
					</div>

				<?php }; ?>
			</div>
		<?php }; ?>

		<h3 class="heading-2 ui_sub_title">
			Headings
		</h3>

		<div class="">
			<h1 class="heading-1">heading-1</h1>
			<h2 class="heading-2">heading-2</h2>
			<h3 class="heading-3">heading-3</h3>
			<h4 class="heading-4">heading-4</h4>
			<h5 class="heading-5">heading-5</h5>
			<h6 class="heading-6">heading-6</h6>
		</div>
	</div>
</section>