<?php

$logo = get_field('site-logo', 'option');
$button = get_field('cta-button', 'option');
$email = get_field('email', 'option');
$phone = get_field('phone', 'option');

?>

<header class="header js-header" id="header">

	<!-- Header Top -->
	<div class="header__top">
		<div class="section_in">
			<div class="header__row">
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
				<div class="header__social_w">
					<?php get_template_part('template-parts/social-media-list') ?>
				</div>
			</div>
		</div>
	</div>
	<!-- Header Top End -->

	<div class="header__bot">
		<div class="section_in">
			<div class="header__row">
				<?php if ($logo) { ?>
					<a class="header__logo" href="<?php echo home_url() ?>">
						<img <?php acf_image_attrs($logo) ?> />
					</a>
				<?php }; ?>

				<?php wp_nav_menu([
					'theme_location' => 'header-menu',
					'container' => 'nav',
					'menu_class' => 'header__menu_list',
					'container_class' => 'header__menu',
				]) ?>

				<?php if ($button) { ?>
					<div class="header__button_w">
						<a class="header__button button button--primary" <?php acf_link_attrs($button) ?>>
							<?php echo $button['title'] ?>
						</a>
					</div>
				<?php }; ?>

				<!-- Menu Burger Button -->
				<button class="header__menu_trigger js-header-menu-trigger" type="button" aria-label="Toggle menu">
					<span></span>
				</button>
				<!-- Menu Burger Button End -->

			</div>
		</div>
	</div>
</header>

<!-- Mobile Menu Start -->
<div class="mobile_menu js-mobile-menu">
	<div class="mobile__in">
		<div class="mobile_menu__row">
			<div class="mobile_menu__heading">
				<?php if ($logo) { ?>
					<a class="mobile_menu__logo" href="<?php echo home_url() ?>">
						<img <?php acf_image_attrs($logo) ?> />
					</a>
				<?php }; ?>

				<button class="header__menu_trigger header__menu_trigger--mobile js-header-menu-trigger" type="button" aria-label="Toggle menu">
					<span></span>
				</button>

			</div>
			<?php wp_nav_menu([
				'theme_location' => 'header-menu',
				'container' => 'nav',
				'menu_class' => 'mobile_menu__list',
				'container_class' => 'mobile_menu__wrapper',
			]) ?>

			<?php if ($button) { ?>
				<a class="mobile-menu__button button button--primary" <?php acf_link_attrs($button) ?>>
					<?php echo $button['title'] ?>
				</a>
			<?php }; ?>
			<div class="mobile-menu__social_w">
				<?php get_template_part('template-parts/social-media-list') ?>
			</div>
		</div>
	</div>
</div>
<!-- Mobile End -->