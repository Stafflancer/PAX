<?php
/**
 * Functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package PAX
 * @since   1.0.0
 */

/*
 * Check if the WordPress version is 6.0 or higher, and if the PHP version is at least 7.4.
 * If not, do not activate.
 */
if ( version_compare( $GLOBALS['wp_version'], '6.0', '<' ) || version_compare( PHP_VERSION_ID, '70400', '<' ) ) {
	require( 'inc/back-compat.php' );

	return;
}

/**
 * Theme setup. Should be included first.
 */
require( 'inc/template-setup.php' );

/**
 * Block patterns.
 */
//require( 'inc/block-patterns.php' );

/**
 * Custom functions that act independently of the theme templates.
 */
require( 'inc/template-extras.php' );

/**
 * Load custom filters and hooks.
 */
require( 'inc/template-hooks.php' );

/**
 * WordPress hardening.
 */
require( 'inc/template-security.php' );

/**
 * Load styles and scripts.
 */
require( 'inc/template-scripts.php' );

/**
 * Custom template tags for this theme.
 */
require( 'inc/template-tags.php' );

/**
 * Template ACF setup.
 */
require( 'inc/acf/acf.php' );

/**
 * WordPress Customization.
 */
require( 'inc/wordpress-customization.php' );

/**
 * Template optimization.
 */
require( 'inc/template-optimization.php' );