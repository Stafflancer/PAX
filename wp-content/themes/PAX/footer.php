<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package PAX
 */
?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="footer-top">
						<div class="first-row">
							<div class="footer-logo-outer">
								<?php pax_display_footer_logo(); ?>
							</div>
							<div class="social-menu col-md-12 col-sm-12">
								<?php pax_display_social_network_links(); ?>
							</div>
						</div>
						<div class="mid-row">
							<div class="footer-form-newsletter">
								<?php pax_display_footer_form(); ?>
							</div>
						</div>
						<div class="right-row"><?php
							if(have_rows('contact_group', 'option')){ ?>
								<div class="address-list">
									<div class="footer-contact-btn"><?php
										while(have_rows('contact_group', 'option')){
											the_row();
											$address = get_sub_field('address');
											$phone = get_sub_field('phone');
											if ($address){ ?>
												<div class="footer-address">
													 <?php echo $address; ?>
												</div><?php
											}
											if ( ! empty( $phone ) && ! empty( $phone['url'] ) ){?>
												<div class="footer-phone-number">
									            	<a href="<?php echo esc_url( $phone['url'] ); ?>" class="footer-phone-number" target="<?php echo $phone['target']; ?>"><?php echo $phone['title']; ?></a>
									            </div><?php
									        } 
									    } ?>
								    </div>
								</div><?php
							} 
							$buttons = get_field('footer_buttons_group', 'option');
							if(!empty($buttons)){
								pax_display_buttons($buttons);
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row"><?php
				if ( has_nav_menu( 'footer' ) ) { ?>
					<div class="col-md-12 col-sm-12">
						<div id="site-footer-navigation-1" class="footer-navigation menu-services-footer-menu-new" aria-label="<?php esc_attr_e( 'Footer Navigation', THEME_TEXT_DOMAIN ); ?>"><?php
							wp_nav_menu( array(
								'menu'           => 'Footer Menu',
								'theme_location' => 'footer',
								'menu_class'     => 'footer-menu menu',
								'container'      => 'ul',
								'before'         => '',
								'after'          => '',
								'depth'          => 3,
								'link_before'    => '',
								'link_after'     => '',
							) );?>
						</div>
					</div><?php
				} ?>
			</div>
		</div>
		<div class="footer-logo">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="site-info">
							<?php pax_display_copyright_section(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
			<!-- .site-info -->
	</footer><!-- #colophon -->
	<?php wp_footer(); ?>
	<?php
	if ( function_exists( 'pax_load_inline_svg' ) ) {
		echo pax_load_inline_svg( 'svg-icons-defs.svg' );
	}
	?>
</body>
</html>