<?php
/*
 * Default Page Template
 */

$breadcrumbs = get_field('breadcrumbs');
?>

<?php


get_header();
?>
<div class="wrapper">
	<main id="main" class="base">
		
		<?php
		if (!is_front_page() && function_exists('yoast_breadcrumb') && $breadcrumbs) : ?>
			<?php get_template_part('/template-parts/breadcrumbs'); ?>
		<?php endif; ?>

		<?php
		if (have_rows('content__page')) :
			while (have_rows('content__page')) : the_row();
				get_template_part('blocks/' . get_row_layout());
			endwhile;

		endif;
		?>

	</main>

	<?php
	get_footer();
	?>