<?php

$logo = get_field('site-logo', 'option');
$button = get_field('cta-button', 'option');
$email = get_field('email', 'option');
$phone = get_field('phone', 'option');

?>

<header class="header js-header" id="header">

	<!-- Header Top -->
	<div class="header__top">
		<div class="container">
			<div class="header__inner">
				<?php if ($email || $phone) { ?>
					<div class="header__contacts">
						<?php if ($email) { ?>
							<a class="header__link" <?php acf_link_attrs($email) ?>>
								<span class="header__label"><?php _e('E-Mail') ?></span>
								<span class="header__value"><?php echo $email['title'] ?></span>
							</a>
						<?php }; ?>
						<?php if ($phone) { ?>
							<a class="header__link" <?php acf_link_attrs($phone) ?>>
								<span class="header__label"><?php _e('Tel.') ?></span>
								<span class="header__value"><?php echo $phone['title'] ?></span>
							</a>
						<?php }; ?>
					</div>
				<?php }; ?>
				<?php get_template_part('template-parts/social-media-list') ?>
			</div>
		</div>
	</div>
	<!-- Header Top End -->

	<div class="container header__bot">
		<div class="header__inner">
			<?php if ($logo) { ?>
				<a class="header__logo" href="<?php echo home_url() ?>">
					<img <?php acf_image_attrs($logo) ?> />
				</a>
			<?php }; ?>

			<?php wp_nav_menu([
				'theme_location' => 'header-menu',
				'container' => 'nav',
				'menu_class' => 'header-menu',
				'container_class' => 'header-menu',
			]) ?>

			<?php if ($button) { ?>
				<a class="header__button | button " <?php acf_link_attrs($button) ?>>
					<?php echo $button['title'] ?>
				</a>
			<?php }; ?>


			<!-- Mobile Start -->
			<!-- Menu Burger Button -->
			<button class="site-header__menu_trigger js-header-menu-trigger" type="button" aria-label="Toggle menu">
				<span></span>
			</button>
			<!-- Menu Burger Button End -->

			<!-- Mobile Menu Start -->
			<div class="mobile-menu | js-mobile-menu" style="display {none">
				<div class="container">
					<div class="mobile-menu__inner">
						<?php wp_nav_menu([
							'theme_location' => 'header-menu',
							'container' => 'nav',
							'menu_class' => 'header-menu',
							'container_class' => 'header-menu',
						]) ?>

						<?php if ($button) { ?>
							<a class="header__button mobile-menu__button | button" <?php acf_link_attrs($button) ?>>
								<?php echo $button['title'] ?>
							</a>
						<?php }; ?>
					</div>
				</div>
			</div>
			<!-- Mobile Menu End -->
			<!-- Mobile End -->

		</div>
	</div>
</header>