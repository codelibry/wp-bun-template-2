<?php

$list = get_field('ui-typography-list');
?>

<section class="ui_typography section">
	<div class="section_in">

		<h2 class="heading-2 ui_title">
			02 Typography
		</h2>

		<div class="ui_typography__row">

			<div class="ui_typography__col">

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
								<div class="ui_typography__font_name">Font name: <?php echo $font; ?></div>
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
			</div>
			<div class="ui_typography__col">
				<h3 class="heading-2 ui_sub_title">
					Headings
				</h3>

				<div class="ui_typography__headings">
					<h1 class="heading-1">heading-1</h1>
					<h2 class="heading-2">heading-2</h2>
					<h3 class="heading-3">heading-3</h3>
					<h4 class="heading-4">heading-4</h4>
					<h5 class="heading-5">heading-5</h5>
					<h6 class="heading-6">heading-6</h6>
				</div>

			</div>
		</div>

		<h3 class="heading-3 ui_sub_title">
			Paragraphs / semi bold/ Links
		</h3>
		<div class="ui_typography__content">
			<p><strong>Lorem ipsum</strong> odor amet, consectetuer adipiscing elit. Nec mi integer natoque faucibus turpis aptent class nulla. Laoreet sem sed dolor ut nascetur quisque turpis. Massa blandit efficitur aenean platea erat turpis praesent tellus. Habitasse donec habitasse; semper himenaeos lobortis metus. Efficitur nibh tincidunt volutpat mollis ultricies amet feugiat ultrices. Placerat integer euismod fusce egestas posuere.</p>
			<p><i>Lorem ipsum odor</i> amet, consectetuer adipiscing elit. Nec mi integer natoque faucibus turpis aptent class nulla. Laoreet sem sed dolor ut nascetur quisque turpis. Massa blandit efficitur aenean platea erat turpis praesent tellus. Habitasse donec habitasse; semper himenaeos lobortis metus. Efficitur nibh tincidunt volutpat mollis ultricies amet feugiat ultrices. Placerat integer euismod fusce egestas posuere.</p>
			<p> <a href="#">Lorem ipsum odor amet</a>, consectetuer adipiscing elit. Nec mi integer natoque faucibus turpis aptent class nulla. Laoreet sem sed dolor ut nascetur quisque turpis. Massa blandit efficitur aenean platea erat turpis praesent tellus. Habitasse donec habitasse; semper himenaeos lobortis metus. Efficitur nibh tincidunt volutpat mollis ultricies amet feugiat ultrices. Placerat integer euismod fusce egestas posuere.</p>
			<h4>List</h4>
			<h6>This is an example of a bulleted list:</h6>
			<ul>
				<li>Lorem ipsum</li>
				<li>Lorem ipsum</li>
				<li>Lorem ipsum</li>
				<li>Lorem ipsum</li>
			</ul>
			<h6>This is an example of a numbered list:</h6>
			<ol>
				<li>Lorem ipsum</li>
				<li>Lorem ipsum</li>
				<li>Lorem ipsum</li>
				<li>Lorem ipsum</li>
			</ol>
			<h4>Blockquotes</h4>
			<blockquote>“Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua”</blockquote>
		</div>
	</div>
</section>