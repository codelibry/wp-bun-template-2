<?php

$list = get_field('ui-button-list');
?>

<section class="ui_btns section">
	<div class="section_in">
		<h2 class="heading-2 ui_title">
			Buttons
		</h2>
		<?php if ($list) { ?>
			<div class="ui_btns__list">
				<?php foreach ($list as $item) { ?>
					<div class="ui_btns__item">
						<a href="#" class='<?php echo $item['class-name'] ?>'> <?php echo $item['class-name'] ?></a>
					</div>
				<?php }; ?>
			</div>
		<?php }; ?>
	</div>
	</div>
</section>