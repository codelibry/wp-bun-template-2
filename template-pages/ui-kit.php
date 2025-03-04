<?php
/*
Template Name: Ui Kit
*/
?>

<?php get_header(); ?>

<main class="base">

	<?php get_template_part('/template-parts/ui-kit/colors'); ?>

	<?php get_template_part('/template-parts/ui-kit/buttons'); ?>

	<?php get_template_part('/template-parts/ui-kit/typography'); ?>

	<?php get_template_part('/template-parts/ui-kit/popups'); ?>

	<?php get_template_part('/template-parts/ui-kit/form'); ?>

	<?php get_template_part('/template-parts/ui-kit/grid'); ?>

	<?php get_template_part('/template-parts/ui-kit/block-content-wysiwig'); ?>

	<?php get_template_part('/template-parts/ui-kit/breadcrumbs'); ?>


	<?php
	
	/*
	get_template_part('/template-parts/ui-kit/duplex-1'); ?>

	<?php get_template_part('/template-parts/ui-kit/content-block-1'); ?>

	<?php get_template_part('/template-parts/ui-kit/content-block-box'); ?>

	<?php

	/*

	to add:

	https://app.asana.com/0/1208737330438359/1209006578567502

	also classes for grid, spacings between sections

	<?php get_template_part('/template-parts/ui-kit/accordions'); ?>

	<?php get_template_part('/template-parts/ui-kit/tabs'); ?>

	
	get_template_part('/template-parts/ui-kit/cards');

	get_template_part('/template-parts/ui-kit/sliders'); */ ?>

</main>

<?php get_footer(); ?>