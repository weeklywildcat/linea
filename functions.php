<?php
/**
 * Weekly Wildcat theme functions.
 *
 * @package WeeklyWildcat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WEEKLY_WILDCAT_VERSION', '0.5.0' );

/**
 * Theme setup.
 */
function weekly_wildcat_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets', 'search-form' ) );

	add_editor_style( 'assets/css/editor.css' );
}
add_action( 'after_setup_theme', 'weekly_wildcat_setup' );

/**
 * Enqueue front-end assets.
 */
function weekly_wildcat_enqueue_assets() {
	wp_enqueue_style(
		'weekly-wildcat-style',
		get_stylesheet_uri(),
		array(),
		WEEKLY_WILDCAT_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'weekly_wildcat_enqueue_assets' );

/**
 * Register custom block pattern categories.
 */
function weekly_wildcat_register_pattern_categories() {
	register_block_pattern_category(
		'weekly-wildcat-homepage',
		array(
			'label'       => __( 'Weekly Wildcat Homepage', 'weekly-wildcat' ),
			'description' => __( 'Homepage patterns for student newspaper layouts.', 'weekly-wildcat' ),
		)
	);

	register_block_pattern_category(
		'weekly-wildcat-sections',
		array(
			'label'       => __( 'Weekly Wildcat Sections', 'weekly-wildcat' ),
			'description' => __( 'Reusable story grids, section lists, and newspaper modules.', 'weekly-wildcat' ),
		)
	);

	register_block_pattern_category(
		'weekly-wildcat-articles',
		array(
			'label'       => __( 'Weekly Wildcat Articles', 'weekly-wildcat' ),
			'description' => __( 'Article endings, author modules, comments, and related-story patterns.', 'weekly-wildcat' ),
		)
	);

	register_block_pattern_category(
		'weekly-wildcat-modules',
		array(
			'label'       => __( 'Weekly Wildcat Modules', 'weekly-wildcat' ),
			'description' => __( 'Reusable callouts, alerts, photo strips, and newsroom modules.', 'weekly-wildcat' ),
		)
	);
}
add_action( 'init', 'weekly_wildcat_register_pattern_categories' );
