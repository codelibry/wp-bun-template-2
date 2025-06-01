<?php

$menus = [
	[
		'title' => __('About', 'theme-menu'),
		'menu' => wp_nav_menu([
			'theme_location' => 'footer-menu',
			'echo' => false,
		])
	],
	[
		'menu' => wp_nav_menu([
			'theme_location' => 'policy-and-terms',
			'echo' => false,
		])
	],

];

$info_title = get_field('footer_info_title', 'option');
$info_descr = get_field('footer_company_info', 'option');
$copyright = get_field('copyright', 'option');
$logo = get_field('footer_logo', 'option');

?>

<footer class="footer" id="footer">
	<div class="footer__top">
		<div class="section_in">
			<div class="row">
				<div class="col-lg-5">
					<?php if ($logo) { ?>
						<a class="footer__logo" href="<?php echo home_url() ?>">
							<img <?php acf_image_attrs($logo) ?> />
						</a>
					<?php }; ?>
					<div class="footer-menu__social_w">
						<?php get_template_part('template-parts/social-media-list') ?>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="footer__row">
						<?php if ($menus[0]) { ?>
							<div class="footer__col">
								<div class="footer__menu_w">
									<h5 class="footer__title">
										<?php echo $menus[0]['title'] ?>
									</h5>
									<?php echo $menus[0]['menu'] ?>
								</div>
							</div>
						<?php }; ?>
						<div class="footer__col">
							<div class="footer__menu_w">
								<h5 class="footer__title">
									<?php echo $info_title ?>
								</h5>
								<div class="footer__descr article-block">
									<?php echo $info_descr ?>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer__bottom">
		<div class="section_in">
			<div class="footer__bottom_inner">
				<?php if ($copyright): ?>
					<div class="footer__bottom_copyright">
						<p><?php echo $copyright ?></p>
					</div>
				<?php endif; ?>
				<?php if ($menus[1]) { ?>
					<div class="footer__bottom_menu">
						<?php echo $menus[1]['menu'] ?>
					</div>
				<?php }; ?>
			</div>
		</div>
	</div>
</footer>



<?php the_field('footer_scripts', 'option') ?>