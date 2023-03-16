<?php
/**
 * Theme setup.
 *
 * @package PAX
 */

/**
 * The theme version.
 *
 * @since 1.0.0
 */
$theme_version = wp_get_theme()->get( 'Version' );

$version_string = is_string( $theme_version ) ? $theme_version : null;

define( 'PAX_VERSION', $version_string );
define( 'THEME_TEXT_DOMAIN', 'pax' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @author Bop Design
 */
if ( ! function_exists( 'pax_setup' ) ) {
	function pax_setup() {
		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		/**
		 * This feature enables plugins and themes to manage the document title tag (1). This should be used in place of
		 * wp_title() (2) function.
		 *
		 * @link https://codex.wordpress.org/Title_Tag (1)
		 *       https://developer.wordpress.org/reference/functions/wp_title/ (2)
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Remove type="text/javascript" and type="text/css" from enqueued scripts and styles.
		 */
		add_theme_support( 'html5', [ 'script', 'style' ] );

		/**
		 * Register new image sizes.
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_image_size/
		 */
		add_theme_support( 'post-thumbnails' );
		/**
		 * Add featured image sizes.
		 * Sizes are optimized and cropped for landscape aspect ratio.
		 */
//		add_image_size( 'rename-me', width, height );
//		add_image_size( 'rename-me-too', width, height, true ); // true if we need cropped size for consistency.
		add_image_size( 'featured-post-small', 340, 116, true );
		add_image_size( 'featured-post-medium', 524, 180, true );
		add_image_size( 'featured-post-large', 920, 316, true );
		// Add additional image sizes.
		add_image_size( 'full-width', 1920, 1080 );

		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( THEME_TEXT_DOMAIN, get_template_directory() . '/languages' );

		// Register navigation menus.
		register_nav_menus( [
			'primary' => esc_html__( 'Primary Menu', THEME_TEXT_DOMAIN ),
			'footer'  => esc_html__( 'Footer Menu', THEME_TEXT_DOMAIN ),
			'mobile'  => esc_html__( 'Mobile Menu', THEME_TEXT_DOMAIN ),
		] );

		/**
		 * Disabling the default block patterns.
		 * WordPress comes with a number of block patterns built-in, themes can opt-out of the bundled patterns and
		 * provide their own set.
		 */
		remove_theme_support( 'core-block-patterns' );

		// Enqueue editor styles.
		add_theme_support( 'editor-styles' );
		add_editor_style( [
			'assets/css/vendor/bootstrap-grid.css',
			'assets/css/vendor/bootstrap-utilities.css',
			'style.css',
		] );

		/**
		 * Load additional block styles.
		 */
		$styled_blocks = [ 'columns', 'media-text', 'quote' ];

		foreach ( $styled_blocks as $block_name ) {
			if ( file_exists( get_theme_file_path( "assets/css/blocks/$block_name.css" ) ) ) {
				$args = array(
					'handle' => "pax-acf-$block_name",
					'src'    => get_theme_file_uri( "assets/css/blocks/$block_name.css" ),

					$args['path'] = get_theme_file_path( "assets/css/blocks/$block_name.css" ),
				);

				// Replace the "core" prefix if you are styling blocks from plugins.
				wp_enqueue_block_style( "core/$block_name", $args );
			}
		}
	}
}

add_action( 'after_setup_theme', 'pax_setup' );