<?php

// ACF Settings


/*
==================
 ACF options page
==================
*/
if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' => 'Site Settings',
		'menu_title' => 'Site Settings',
		'menu_slug' => 'site-settings',
		'capability' => 'edit_posts',
		'redirect' => false
	));

	// Place, where we add social media links
	acf_add_options_sub_page(array(
		'page_title' => 'Social Media',
		'menu_title' => 'Social media',
		'parent_slug' => 'site-settings',
	));

	// Allow client to add GTM, Analytics and other scripts to the head, body etc.
	acf_add_options_sub_page(array(
		'page_title' => 'Scripts',
		'menu_title' => 'Scripts',
		'parent_slug' => 'site-settings',
	));

	// Allow client to change 404 copy
	acf_add_options_sub_page(array(
		'page_title' => '404 - Error page',
		'menu_title' => '404 - Error page',
		'parent_slug' => 'site-settings',
	));

	// Header Settings
	acf_add_options_sub_page(array(
		'page_title' => 'Header Settings',
		'menu_title' => 'Header Settings',
		'parent_slug' => 'site-settings',
	));

	// Footer Settings
	acf_add_options_sub_page(array(
		'page_title' => 'Footer Settings',
		'menu_title' => 'Footer Settings',
		'parent_slug' => 'site-settings',
	));
}


<?php

// ACF Settings


/*
==================
 ACF options page
==================
*/
if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' => 'Site Settings',
		'menu_title' => 'Site Settings',
		'menu_slug' => 'site-settings',
		'capability' => 'edit_posts',
		'redirect' => false
	));

	// Place, where we add social media links
	acf_add_options_sub_page(array(
		'page_title' => 'Social Media',
		'menu_title' => 'Social media',
		'parent_slug' => 'site-settings',
	));

	// Allow client to add GTM, Analytics and other scripts to the head, body etc.
	acf_add_options_sub_page(array(
		'page_title' => 'Scripts',
		'menu_title' => 'Scripts',
		'parent_slug' => 'site-settings',
	));

	// Allow client to change 404 copy
	acf_add_options_sub_page(array(
		'page_title' => '404 - Error page',
		'menu_title' => '404 - Error page',
		'parent_slug' => 'site-settings',
  ));
  

  	// Temporary disabled because we're hooked into previous settings


	// Allow client to change Header Content
	// acf_add_options_sub_page(array(
	// 	'page_title' => 'Header Settings',
	// 	'menu_title' => 'Header Settings',
	// 	'parent_slug' => 'site-settings',
	// ));

	// Footer Settings
	acf_add_options_sub_page(array(
		'page_title' => 'Footer Settings',
		'menu_title' => 'Footer Settings',
		'parent_slug' => 'site-settings',
	));
}

// // Register multiple thumbnail filters dynamically.
// $layouts = [
// 	'hero',
// 	'intro-text',
// 	'stepper',
// 	'stepper-2',
// 	'banner',
// 	'features',
// 	'solutions',
// 	'services',
// 	'feed-2',
// 	'cards-1',
// 	'quote',
// 	'cta',
//   ];
  
//   foreach ($layouts as $image) {
// 	  add_filter("acfe/flexible/thumbnail/layout={$image}", function($thumbnail, $field, $layout) use ($image) {
// 		  return get_template_directory_uri() . "/assets/blocks-preview/{$image}.png";
// 	  }, 10, 3);
//   }
  