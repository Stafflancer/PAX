<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package PAX
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<?php
	if ( isset( $_ENV['PANTHEON_ENVIRONMENT'] ) && 'live' !== $_ENV['PANTHEON_ENVIRONMENT'] ):
		$apiKey = ( 'test' !== $_ENV['PANTHEON_ENVIRONMENT'] ) ? 'wkwf1fn3xyszudkaksjf7g' : 'hgxm4pslvhl3z63iumqxqq';
		?>
		<script src="https://www.bugherd.com/sidebarv2.js?apikey=<?php echo $apiKey; ?>>" async></script>
	<?php endif; ?>
</head>
<body <?php body_class( 'site-wrapper no-js' ); ?>>
<?php wp_body_open(); ?>

<div class="header-top-main">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', THEME_TEXT_DOMAIN ); ?></a>
	<?php
	$header_top_descriptions = get_field( 'header_top_descriptions', 'option' );
	$header_top_buttons      = get_field( 'header_top_buttons', 'option' );
	if ( ! empty( $header_top_descriptions ) || ! empty( $header_top_buttons ) ) {
		?>
		<div class="header-top-content">
			<div class="header-content">
				<div class="header-cross-icon"></div>
				<div class="top-description">
					<?php echo $header_top_descriptions; ?>
				</div>
				<?php pax_display_buttons( $header_top_buttons ); ?>
			</div>
		</div>
	<?php
	}

	$site_logo       = get_field( 'site_logo', 'option' );
	$wrapper_classes = 'site-header w-100';
	$wrapper_classes .= $site_logo ? ' has-logo' : '';
	$wrapper_classes .= has_nav_menu( 'primary' ) || has_nav_menu( 'mobile' ) ? ' has-menu' : '';
	?>
	<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>" role="banner">
		<div class="container position-relative">
			<div class="row align-items-center">
				<div class="col-6 col-lg-2">
					<div class="site-branding header-logo">
						<?php if ( $site_logo ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<img src="<?php echo wp_get_attachment_image_url( $site_logo, 'medium' ); ?>"
								     class="logo" width="177" height="51" alt="PAX Logo"/>
							</a>
						<?php else: ?>
							<p class="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
								   rel="home"><?php bloginfo( 'name' ); ?></a>
							</p>
						<?php endif; ?>
					</div><!-- .site-branding -->
				</div>

				<div class="col-6 col-lg-10">
					<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'mobile' ) ) : ?>
						<button type="button" class="navbar-toggle off-canvas-open d-block d-lg-none p-0 menu-bar-mobile" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open Menu', THEME_TEXT_DOMAIN ); ?>">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					<?php endif; ?>
					<div class="header-navigation-outer">
						<nav id="site-navigation" class="main-navigation navigation-menu d-lg-flex justify-content-end" aria-label="<?php esc_attr_e( 'Main Navigation', THEME_TEXT_DOMAIN ); ?>">
							<?php
							wp_nav_menu( [
								'theme_location' => 'primary',
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'menu dropdown d-flex justify-content-end',
								'container'      => false,
								'fallback_cb'    => false,
							] );

							$buttons = get_field( 'navigation_buttons', 'option' );
							pax_display_buttons( $buttons );

							$search_shortcode = get_field( 'search_shortcode', 'option' );
							if ( $search_shortcode ) {
								?>
								<div class="search-icon mobile-search-icon ">
									<div class="search-form">
										<?php echo do_shortcode( $search_shortcode ); ?>
									</div>
								</div>
							<?php } ?>
						</nav><!-- #site-navigation -->
						<div class="search-icon search-desktop">
							<div class="header-search-icon">
								<svg id="search-icon" xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 19 20">
									<circle cx="8" cy="8" r="6.5" fill="none" stroke="#fff" stroke-width="3"/>
									<path d="M17.5,18.5,12.5,13.5" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="3"/>
								</svg>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		$search_shortcode = get_field( 'search_shortcode', 'option' );
		if ( $search_shortcode ) {
			?>
			<div class="search-icon search-desktop">
				<div class="search-form" style="display: none;">
					<?php echo do_shortcode( $search_shortcode ); ?>
				</div>
			</div>
		<?php } ?>
	</header>
</div>
<!-- #masthead -->