<?php
if ( ! function_exists( 'pax_scripts' ) ) {
	/**
	 * Enqueue scripts and styles.
	 *
	 * @return void
	 */

	function pax_scripts() {
		wp_enqueue_style( 'bootstrap-grid', get_theme_file_uri( '/assets/css/vendor/bootstrap-grid.min.css' ), [], null );
		wp_enqueue_style( 'bootstrap-utilities', get_theme_file_uri( '/assets/css/vendor/bootstrap-utilities.min.css' ), [], null );
		wp_enqueue_style( 'main-css', get_stylesheet_directory_uri() . '/assets/css/main.min.css' );
		wp_enqueue_script( 'cookie-script-js', get_theme_file_uri( '/assets/js/jquery.cookie.min.js' ), [], null, true );
		wp_enqueue_script( 'custom-script-js', get_theme_file_uri( '/assets/js/custom-script.js' ), [], null, true );
	}
}

add_action( 'wp_enqueue_scripts', 'pax_scripts' );

/**
 * Register block script
 */
function pax_register_block_script() {
	wp_register_style( 'swiper-style', get_template_directory_uri() . '/assets/css/vendor/swiper-bundle.min.css');

	wp_register_script( 'swiper-script', get_template_directory_uri() . '/assets/js/vendor/swiper-bundle.min.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'hero-banner-home-script', get_template_directory_uri() . '/blocks/hero-banner-home/hero-banner-home.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'slider-logos-script', get_template_directory_uri() . '/blocks/slider-logos/slider-logos.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'slider-cards-with-icons-script', get_template_directory_uri() . '/blocks/slider-cards-with-icons/slider-cards-with-icons.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'hero-banner-gallery-script', get_template_directory_uri() . '/blocks/hero-banner-gallery/hero-banner-gallery.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'slider-cards-with-tooltip-image-script', get_template_directory_uri() . '/blocks/slider-cards-with-tooltip-image/slider-cards-with-tooltip-image.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'slider-postcards-script', get_template_directory_uri() . '/blocks/slider-postcards/slider-postcards.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'media-with-side-accordion-script', get_template_directory_uri() . '/blocks/media-with-side-accordion/side-accordion.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'search-filter-shortcode-script', get_template_directory_uri() . '/blocks/search-filter-shortcode/search-filter-shortcode.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'slider-simple-cards-with-icons-script', get_template_directory_uri() . '/blocks/slider-simple-cards-with-icons/slider-simple-cards-with-icons.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'side-by-side-testimonials-script', get_template_directory_uri() . '/blocks/side-by-side-testimonials/side-by-side-testimonials.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'slider-upcoming-events-script', get_template_directory_uri() . '/blocks/slider-upcoming-events/upcoming-events.js', [ 'jquery', 'acf' ] );

	wp_register_style( 'odometer-theme-default-style', get_template_directory_uri() . '/assets/css/vendor/odometer-theme-default.css');

	wp_register_script( 'odometer-script', get_template_directory_uri() . '/assets/js/vendor/odometer.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'stats-script', get_template_directory_uri() . '/blocks/stats/stats.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'cards-with-tooltip-image-script', get_template_directory_uri() . '/blocks/cards-with-tooltip-image/cards-with-tooltip-image.js', [ 'jquery', 'acf' ] );

	wp_register_script( 'latest-reads-script', get_template_directory_uri() . '/blocks/latest-reads/latest-reads.js', [ 'jquery', 'acf' ] );
}
add_action( 'wp_enqueue_scripts', 'pax_register_block_script' );

if ( ! function_exists( 'pax_preload_assets' ) ) {
	/**
	 * Preload styles and scripts.
	 *
	 * @return void
	 */
	function pax_preload_assets() {
		?>
		<link rel="preload" href="<?php echo esc_url( get_theme_file_uri( '/assets/css/vendor/bootstrap-grid.min.css' ) ); ?>" as="style">
		<link rel="preload" href="<?php echo esc_url( get_theme_file_uri( '/assets/css/vendor/bootstrap-utilities.min.css' ) ); ?>" as="style">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
		<?php
	}
}

add_action( 'wp_head', 'pax_preload_assets', 1 );