<?php
/*
Template Name: Ui Kit
*/
?>

<?php get_header(); ?>

<main class="base">

	<?php get_template_part('/template-parts/ui-kit/colors'); ?>

	<?php get_template_part('/template-parts/ui-kit/typography'); ?>

	<?php get_template_part('/template-parts/ui-kit/buttons'); ?>

	<?php get_template_part('/template-parts/ui-kit/accordions'); ?>

	<?php get_template_part('/template-parts/ui-kit/tabs'); ?>

	<?php get_template_part('/template-parts/ui-kit/popups'); ?>

	<?php get_template_part('/template-parts/ui-kit/form'); ?>

	<?php get_template_part('/template-parts/ui-kit/cards'); ?>

	<?php get_template_part('/template-parts/ui-kit/sliders'); ?>

</main>

<?php get_footer(); ?>