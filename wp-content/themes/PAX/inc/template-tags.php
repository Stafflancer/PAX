<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some functionality here could be replaced by core features.
 *
 * @package PAX
 */


if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

/**
 * Load an inline SVG.
 *
 * @param string $filename The filename of the SVG you want to load.
 *
 * @return string The content of the SVG you want to load.
 */
function pax_load_inline_svg( $filename ) {
	// Add the path to your SVG directory inside your theme.
	$svg_path = '/assets/images/svg-icons/';

	// Check the SVG file exists
	if ( file_exists( get_stylesheet_directory() . $svg_path . $filename ) ) {
		// Load and return the contents of the file
		return file_get_contents( get_stylesheet_directory_uri() . $svg_path . $filename );
	}

	// Return a blank string if we can't find the file.
	return '';
}

/**
 * Display SVG Markup.
 *
 * @param array $args The parameters needed to get the SVG.
 *
 * @author WebDevStudios
 *
 */
function pax_display_svg( $args = [] ) {
	$kses_defaults = wp_kses_allowed_html( 'post' );

	$svg_args = [
		'svg'   => [
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true, // <= Must be lower case!
			'color'           => true,
			'stroke-width'    => true,
		],
		'g'     => [ 'color' => true ],
		'title' => [
			'title' => true,
			'id'    => true,
		],
		'path'  => [
			'd'     => true,
			'color' => true,
		],
		'use'   => [
			'xlink:href' => true,
		],
	];

	$allowed_tags = array_merge( $kses_defaults, $svg_args );

	echo wp_kses( pax_get_svg( $args ), $allowed_tags );
}

/**
 * Return SVG markup.
 *
 * @param array $args The parameters needed to display the SVG.
 *
 * @return string Error string or SVG markup.
 * @author PAX Design
 *
 */
function pax_get_svg( $args = [] ) {
	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return esc_attr__( 'Please define default parameters in the form of an array.', THEME_TEXT_DOMAIN );
	}

	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_attr__( 'Please define an SVG icon filename.', THEME_TEXT_DOMAIN );
	}

	// Set defaults.
	$defaults = [
		'color'        => '',
		'icon'         => '',
		'title'        => '',
		'desc'         => '',
		'stroke-width' => '',
		'height'       => '',
		'width'        => '',
	];

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Figure out which title to use.
	$block_title = $args['title'] ? : $args['icon'];

	// Generate random IDs for the title and description.
	$random_number  = wp_rand( 0, 99999 );
	$block_title_id = 'title-' . sanitize_title( $block_title ) . '-' . $random_number;
	$desc_id        = 'desc-' . sanitize_title( $block_title ) . '-' . $random_number;

	// Set ARIA.
	$aria_hidden     = ' aria-hidden="true"';
	$aria_labelledby = '';

	if ( $args['title'] && $args['desc'] ) {
		$aria_labelledby = ' aria-labelledby="' . $block_title_id . ' ' . $desc_id . '"';
		$aria_hidden     = '';
	}

	// Set SVG parameters.
	$color        = ( $args['color'] ) ? ' color="' . $args['color'] . '"' : '';
	$stroke_width = ( $args['stroke-width'] ) ? ' stroke-width="' . $args['stroke-width'] . '"' : '';
	$height       = ( $args['height'] ) ? ' height="' . $args['height'] . '"' : '';
	$width        = ( $args['width'] ) ? ' width="' . $args['width'] . '"' : '';

	// Start a buffer...
	ob_start();

	if($args['icon'] == 'pinterest'){ ?>
		<svg xmlns="http://www.w3.org/2000/svg" width="9.825" height="13.186" viewBox="0 0 9.825 13.186">
		  <path id="Icon_awesome-yelp" data-name="Icon awesome-yelp" d="M1.15,6.19,3.715,7.441a.588.588,0,0,1-.116,1.1L.83,9.232a.587.587,0,0,1-.727-.5,5.078,5.078,0,0,1,.232-2.2.587.587,0,0,1,.814-.34Zm1.133,6.162a5.137,5.137,0,0,0,2.045.827.587.587,0,0,0,.686-.558l.1-2.854a.589.589,0,0,0-1.025-.415L2.178,11.473a.588.588,0,0,0,.105.878ZM6.026,9.52l1.515,2.421a.591.591,0,0,0,.876.142,5.109,5.109,0,0,0,1.358-1.741.592.592,0,0,0-.35-.812L6.709,8.647a.59.59,0,0,0-.683.873Zm3.82-3.405a5.085,5.085,0,0,0-1.3-1.785.588.588,0,0,0-.876.113L6.075,6.81a.588.588,0,0,0,.649.894l2.746-.786a.592.592,0,0,0,.376-.8ZM1.644.778a.589.589,0,0,0-.255.824L4.071,6.249a.588.588,0,0,0,1.1-.294V.59A.584.584,0,0,0,4.537,0,8.251,8.251,0,0,0,1.644.778Z" transform="translate(-0.071 0)"/>
		</svg><?php
	}
	else{ ?>
		<svg
			<?php
			echo pax_get_the_content( $height ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
			echo pax_get_the_content( $width ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
			echo pax_get_the_content( $color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
			echo pax_get_the_content( $stroke_width ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
			?>
			class="icon svg-icon <?php echo esc_attr( $args['icon'] ); ?>"
			<?php
			echo pax_get_the_content( $aria_hidden ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
			echo pax_get_the_content( $aria_labelledby ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
			?>
			role="img">
			<title id="<?php echo esc_attr( $block_title_id ); ?>">
				<?php echo esc_html( $block_title ); ?>
			</title>

			<?php
			// Display description if available.
			if ( $args['desc'] ) :
				?>
				<desc id="<?php echo esc_attr( $desc_id ); ?>">
					<?php echo esc_html( $args['desc'] ); ?>
				</desc>
			<?php endif; ?>

			<?php
			// Use absolute path in the Customizer so that icons show up in there.
			if ( is_customize_preview() ) :
				?>
				<use xlink:href="<?php echo esc_url( get_parent_theme_file_uri( '/assets/images/svg-icons/svg-icons-defs.svg#icon-' . esc_html( $args['icon'] ) ) ); ?>"></use>
			<?php else : ?>
				<use xlink:href="#icon-<?php echo esc_html( $args['icon'] ); ?>"></use>
			<?php endif; ?>
		</svg><?php
	} ?>

	<?php
	// Get the buffer and return.
	return ob_get_clean();
}

/**
 * Echo the copyright text saved in the Theme Settings -> Footer.
 */
function pax_display_copyright_section() {
	// Grab our copyright group from the theme settings.
	$copyright_data = get_field( 'copyright', 'option' );

	if ( $copyright_data ) :
		$copyright_text = '';

		if ( ! empty( $copyright_data['copyright_text'] ) ) {
			$copyright_text = ' ' . $copyright_data['copyright_text'];
		}

		$copyright_links = $copyright_data['copyright_links'];
		?>
		<section class="font-size-small">
			&copy; <?php echo gmdate( 'Y' ); ?><?php echo esc_html( $copyright_text ); ?>
			<?php
			if ( $copyright_links ):
				foreach ( $copyright_links as $link ) {
					$link_url   = $link['link']['url'];
					$link_title = $link['link']['title'];

					echo '<span>&nbsp;|&nbsp;</span><a href="' . $link_url . '">' . $link_title . '</a>';
				}
				?>
			<?php endif; ?>
		</section>
	<?php else: ?>
		<section class="font-size-small">&copy; <?php echo gmdate( 'Y' ) . ' ' . get_bloginfo( 'name' ); ?></section>
	<?php endif; ?>
	<?php
}

/**
 * Display the social links saved in the Theme Settings -> Footer.
 */
function pax_display_social_network_links() {
	// Create an array of our social links for ease of setup.
	// Change the order of the networks in this array to change the output order.
	$theme_options = get_field( 'theme_options', 'option' );
	$social_networks = $theme_options['social_media'];

	if ( $social_networks ) :
		$count = count( $social_networks );
		?>
		<ul class="d-flex social-icons menu">
			<?php
			$i = 1;
			// Loop through our network array.
			foreach ( $social_networks as $network => $network_url ) :
				// Only display the list item if a URL is set.
				if ( ! empty( $network_url ) ) :
					$icon_wrapper_class = 'social-li';

					if ( $count === $i ) {
						$icon_wrapper_class = '';
					}
					?>
					<li class="<?php echo esc_attr( $icon_wrapper_class ); ?>">
						<a href="<?php echo esc_url( $network_url ); ?>" target="_blank" class="social-icon d-flex align-items-center justify-content-center rounded-circle <?php echo esc_attr( $network ); ?>">
							<?php
							pax_display_svg( [
								'icon'   => $network,
								'width'  => '24',
								'height' => '24',
							] );
							?>
							<span class="screen-reader-text">
								<?php
								/* translators: the social network name */
								printf( esc_attr__( 'Link to %s', THEME_TEXT_DOMAIN ), ucwords( esc_html( $network ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
								?>
							</span>
						</a><!-- .social-icon -->
					</li>
				<?php
				$i++;
				endif;
			endforeach;
			?>
		</ul><!-- .social-icons -->
	<?php endif;
}


/**
 * Display the footer logo saved in the Theme Settings -> Footer.
 */
function pax_display_footer_logo() {
	if(have_rows('theme_options', 'option')){ 
		while(have_rows('theme_options', 'option')){
			the_row();
			$footer_logo = get_sub_field('footer_logo');
			if ( !empty($footer_logo) ) { ?>
				<div class="footer-logo-main">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php echo wp_get_attachment_image_url( $footer_logo, 'medium' ); ?>" class="logo" width="177" height="51" alt="pax Logo"/>
					</a>
				</div><?php
			}
			else{ ?>
				<p class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</p><?php
			}
		}
	}
}


/**
 * Display the breadcrumbs.
 */
function pax_display_breadcrumbs() { 
	if ( is_single() && 'documentation' == get_post_type() ) { ?>
		<div class="breadcrumbs">
	        <div class="breadcrumbs-inner">
	        	<a href="<?php echo get_permalink(182); ?>">SUPPORT</a><span class="divider"> > </span>
	        	<a href="<?php echo get_permalink(224); ?>">DOCUMENTS</a><span class="divider"> > </span>
				<span><?php the_title(); ?></span>
	        </div>
	    </div><?php
	} 
	else{ ?>
		<div class="breadcrumbs">
	        <div class="breadcrumbs-inner"><?php
	            $parent_post = get_post()->post_parent;
	            if (!empty($parent_post)) 
	            { ?>
	                <a href="<?php echo get_permalink($parent_post); ?>">
	                    <?php echo get_the_title($parent_post); ?>
	                </a>
	                <span class="divider"> > </span><?php 
	        	} ?>
				<span><?php the_title(); ?></span>
				<span class="divider"></span>
	        </div>
	    </div><?php
	}
}


/**
 * Display the comments if comments are open or the count is more than 0.
 */
function pax_display_comments() {
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

/**
 * Log Error Message to the debug.log file.
 * Useful when getting a white screen of death or an error in general.
 *
 * @param $var
 *
 * @return false|void
 */
function pax_log_error_to_debug_file( $var ) {
	if ( empty( $var ) ) {
		return false;
	}

	ob_start();
	var_dump( $var );
	$contents = ob_get_contents();
	ob_end_clean();
	error_log( $contents );
}


function enable_svg_upload( $upload_mimes ) {

    $upload_mimes['svg'] = 'image/svg+xml';

    $upload_mimes['svgz'] = 'image/svg+xml';

    return $upload_mimes;

}

add_filter( 'upload_mimes', 'enable_svg_upload', 10, 1 );


if ( ! function_exists( 'pax_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function pax_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail( 'post-thumbnail', array(
						'alt' => the_title_attribute( array(
								'echo' => false,
							) ),
					) );
				?>
			</a>

		<?php
		endif; // End is_singular().
	}
endif;

/* Footer Subscription Form */

function pax_display_footer_form() {
	if(have_rows('subscribe_form', 'option')){ 
		while(have_rows('subscribe_form', 'option')){
			the_row();
				$heading = get_sub_field('heading');
				$content = get_sub_field('content');
				$form = get_sub_field('form');
				if ( !empty($heading) ) { ?>
					<div class="footer-form-heading">
						<span><?php echo $heading; ?></span>
					</div><?php
				}if ( !empty($content) ) { ?>
					<div class="footer-form-content">
						<p><?php echo $heading; ?></p>
					</div><?php
				}if ($form){ ?>
					<div class="gravity_form">
						 <?php echo do_shortcode('[gravityform id="'.$form.'" title="false" description="false" ajax="true"]'); ?>
					</div><?php
				}
		}

	}
}

/**
 * Display header navigation buttons saved in the Theme Settings -> Header.
 */
function pax_display_buttons($buttons) {

	if ( $buttons ) : ?>
		<div class="d-flex is-layout-flex wp-block-buttons"><?php
		// Loop through our buttons array.
		foreach ( $buttons as $button ) :
			// Only display the button item if a URL is set.
			if ( ! empty( $button ) && ! empty( $button['button']['url'] ) ) :
				$button_class  = '';
				$button_target = '';
				$button_text_color_class = '';
				$button_style  = $button['button_style'];
				$button_color_style  = $button['button_color_style'];
				$button_text_color_theme  = $button['button_text_color_theme']['color_picker'];
				if($button_color_style == 'color'){
					$button_color  = $button['button_color']['color_picker'];
					$button_class = ' has-' . esc_attr( $button_color ) . '-background-color has-background';
				}
				else{
					$button_color  = $button['gradient'];
					$button_class = ' has-' . esc_attr( $button_color ) . '-gradient-background';
				}
				if ( ! empty( $button['button']['target'] ) ) {
					$button_target = ' target="' . esc_attr( $button['button']['target'] ) . '"';
				}
				if ( ! empty( $button_text_color_theme ) ) {
					$button_text_color_class = ' has-' . esc_attr( $button_text_color_theme ) . '-color has-text-color';
				}
				if ( ! empty( $button_color ) ) {
					switch ( $button_style ) {
						case 'outline':
							$button_class = ' has-outline-' . esc_attr( $button_color ) . '-color outline-color';
							break;
						case 'fill':
						default:
							$button_class;
							break;
					}
				}
				?>
					<div class="wp-block-button is-style-<?php echo esc_attr( $button_style ); ?>">
						<a class="wp-block-button__link wp-element-button <?php echo esc_attr( $button_class ); ?> <?php echo esc_attr( $button_text_color_class ); ?>"
						   href="<?php echo esc_url( $button['button']['url'] ); ?>"<?php echo $button_target; ?>>
							<?php esc_html_e( $button['button']['title'], THEME_TEXT_DOMAIN ); ?>
						</a>
					</div>
				<?php
			endif;
		endforeach;
		?>
		</div>
	<?php endif;
}


function pax_modal_video($video) {
	$video  = $video['video'];
	if (! empty( $video) ) {
		echo '<div class="video-modal-popup" style="display:none;">
				<div class="video-outer">
				<div class="close-btn"></div>';
					$video_embed = $video;
					preg_match('/src="(.+?)"/', $video_embed, $matches);
					$src = $matches[1];
			        $params = array(
						'controls'  => 1,
						'hd'        => 1,
			        );
					$new_src = add_query_arg($params, $src);
					$iframe = str_replace($src, $new_src, $video_embed);

					$attributes = 'frameborder="0"';
					$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe); ?>
					<figure class="video_embed">
						<?php echo $iframe; ?>
					</figure><?php
		echo '</div></div>';
	}
}

function pax_section_header($section_header) {
	if($section_header){
		$heading  = $section_header['heading'];
		$content = $section_header['content'];
		$add_indicator = $section_header['add_indicator'];
		$indicator_icon = $section_header['indicator_icon'];
		if(!empty($heading) || !empty($content)){ ?>
			<div class="section-header">
				<div class="header-section-outer"><?php 
					if (! empty( $heading )){?>
						<div class="heading_content_section">
							<h2><?php echo($heading); ?></h2>
						</div><?php
					}
					if (! empty($content)){?>
						<div class="content_section">
							<?php echo ($content); ?>
						</div><?php
					} ?>
				</div><?php
				if($add_indicator == 1 && !empty($indicator_icon) && !empty($indicator_icon['url'])){ ?>
					<div class="add-indicato" style="background-image: url(<?php echo esc_url($indicator_icon['url']); ?>);"></div><?php
				} ?>
			</div><?php
		}
	}
}

function pax_cards_section($cards) {
	if(!empty($cards)){ ?>
		<div class="cards swiper cards-slider">
			<div class="swiper-wrapper"><?php
				foreach ( $cards as $card ){
					$icon = $card['icon'];
					$heading = $card['heading'];
					$content = $card['content'];
					$link = $card['link']; 
					if(!empty($icon) && !empty($icon['url']) || !empty($heading) || !empty($content) || !empty($link)){ ?>
						<div class="card swiper-slide">
							<div class="card-inner"><?php
								if(!empty($icon) && !empty($icon['url'])){ ?>
									<div class="card-img">
							  			<img src="<?php echo esc_url($icon['url']); ?>" class="card-img-top" alt="<?php echo $icon['alt']; ?>">
							  		</div><?php
							  	} ?>
							  	<div class="card-body"><?php
							  		if(!empty($heading)){ ?>
								    	<h2 class="card-title"><?php echo $heading; ?></h2><?php
								    } 
								    if(!empty($content)){ ?>
								    	<p class="card-text"><?php echo $content; ?></p><?php
								    } 
								    if(!empty($link) && !empty($link['url'])){ ?>
								    	<a href="<?php echo esc_url($link['url']); ?>" class="custom-link stretched-link" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a><?php
								    } ?>
							  	</div>
							  </div>
						</div><?php
					}
				} ?>
			</div>
			<div class="swiper-button-next"></div>
    		<div class="swiper-button-prev"></div>
    		<div class="swiper-pagination"></div>
		</div><?php
	}
}

function pax_cards_with_tooltip_images($cards) {
	if(!empty($cards)){ ?>
		<div class="simple-card-main">
			<div class="tooltip-images"><?php
				foreach ( $cards as $card ){
					$icon = $card['icon'];
					$heading = $card['heading'];
					$content = $card['content'];
					$link = $card['link']; 
					if(!empty($icon) && !empty($icon['url']) || !empty($heading) || !empty($content) || !empty($link)){ ?>
						<div class="card"><?php
								if(!empty($icon) && !empty($icon['url'])){ ?>
								<div class="card-img">
						  			<img src="<?php echo esc_url($icon['url']); ?>" class="card-img-top" alt="<?php echo $icon['alt']; ?>">
						  		</div>
						  		<?php
							} ?>
							 
						  	<div class="card-body"><?php
						  		if(!empty($heading)){ ?>
							    	<h2 class="card-title"><?php echo $heading; ?></h2><?php
							    } 
							    if(!empty($content)){ ?>
							    	<p class="card-text"><?php echo $content; ?></p><?php
							    } 
							    if(!empty($link) && !empty($link['url'])){ ?>
							    	<a href="<?php echo esc_url($link['url']); ?>" class="custom-link stretched-link" target="<?php echo $link['target']; ?>"></a><?php
							    } ?>
						  	</div>
						</div><?php
					}
				} ?>
			</div>
		</div>
		<div class="simple-card-main-mobile">
			<div class="swiper tooltip-images-mobile-slider">
				<div class="swiper-wrapper tooltip-images"><?php
					foreach ( $cards as $card ){
						$icon = $card['icon'];
						$heading = $card['heading'];
						$content = $card['content'];
						$link = $card['link']; 
						if(!empty($icon) && !empty($icon['url']) || !empty($heading) || !empty($content) || !empty($link)){  ?>
							<div class="tooltip-images swiper-slide">
								<div class="card"><?php
									if(!empty($icon) && !empty($icon['url'])){ ?>
										<div class="card-img">
								  			<img src="<?php echo esc_url($icon['url']); ?>" class="card-img-top" alt="<?php echo $icon['alt']; ?>">
								  		</div>
								  		<?php
									} ?>						 
								  	<div class="card-body"><?php
								  		if(!empty($heading)){ ?>
									    	<h2 class="card-title"><?php echo $heading; ?></h2><?php
									    } 
									    if(!empty($content)){ ?>
									    	<p class="card-text"><?php echo $content; ?></p><?php
									    } 
									    if(!empty($link) && !empty($link['url'])){ ?>
									    	<a href="<?php echo esc_url($link['url']); ?>" class="custom-link stretched-link" target="<?php echo $link['target']; ?>"></a><?php
									    } ?>
								  	</div>
								</div>
							</div><?php
						}
					} ?>
				</div>
				<div class="swiper-button-next"></div>
	    		<div class="swiper-button-prev"></div>
			</div>
		</div><?php
	}
}

function pax_slider_cards_with_tooltip_images($cards) {
	if(!empty($cards)){ ?>
		<div class="cards-tooltip-slider-outer">
			<div class="swiper cards-tooltip-slider simple-card-main">
				<div class="swiper-wrapper tooltip-images"><?php
					foreach ( $cards as $card ){
						$icon = $card['icon'];
						$heading = $card['heading'];
						$content = $card['content'];
						$link = $card['link']; 
						if(!empty($icon) && !empty($icon['url']) || !empty($heading) || !empty($content) || !empty($link)){ ?>
							<div class="card-outer swiper-slide">
								<div class="card"><?php
									if(!empty($icon) && !empty($icon['url'])){ ?>
										<div class="card-img">
								  			<img src="<?php echo esc_url($icon['url']); ?>" class="card-img-top" alt="<?php echo $icon['alt']; ?>">
								  		</div><?php
								  	} ?>
								  	<div class="card-body"><?php
								  		if(!empty($heading)){ ?>
									    	<h2 class="card-title"><?php echo $heading; ?></h2><?php
									    } 
									    if(!empty($content)){ ?>
									    	<p class="card-text"><?php echo $content; ?></p><?php
									    } 
									    if(!empty($link) && !empty($link['url'])){ ?>
									    	<a href="<?php echo esc_url($link['url']); ?>" class="custom-link stretched-link" target="<?php echo $link['target']; ?>"></a><?php
									    } ?>
								  	</div>
								 </div>
							</div><?php
						}
					} ?>
				</div>
				<div class="swiper-button-next"></div>
	    		<div class="swiper-button-prev"></div>
			</div>
		</div><?php
	}
}

function pax_cards_with_image_pattern($cards, $simple_card, $add_card) {
	if(!empty($cards) || !empty($simple_card) && $add_card == 1){ ?>
		<div class="cards-with-image-pattern">
			<div class="cards-image-pattern"><?php
				if(!empty($cards)){
					foreach ( $cards as $card ){
						$image = $card['image'];
						$heading = $card['heading'];
						$content = $card['content'];
						$link = $card['link']; 
						if(!empty($image) && !empty($image['url']) || !empty($heading) || !empty($content) || !empty($link)){ ?>
							<div class="card"><?php
								if(!empty($image) && !empty($image['url'])){ ?>
									<div class="cards-image">
							  			<img src="<?php echo esc_url($image['url']); ?>" class="card-img-top" alt="<?php echo $image['alt']; ?>">
							  		</div><?php
								  	} ?>
								  	<div class="card-body">
								  		<div class="card-body-inner"><?php
								  		if(!empty($heading)){ ?>
									    	<h3 class="card-title"><?php echo $heading; ?></h3><?php
									    } 
									    if(!empty($content)){ ?>
									    	<p class="card-text"><?php echo $content; ?></p><?php
									    } ?>
									</div>
									<div class="card-link"> <?php
									    if(!empty($link) && !empty($link['url'])){ ?>
									    	<a href="<?php echo esc_url($link['url']); ?>" class="custom-link stretched-link" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?> 
									    		<svg xmlns="http://www.w3.org/2000/svg" width="9.59" height="11.371" viewBox="0 0 9.59 11.371">
												  <path id="Path_55163" data-name="Path 55163" d="M6.98,32.948.918,27.263H5.985l3.7,3.7a2.806,2.806,0,0,1,0,3.969l-3.7,3.7H.918Z" transform="translate(-0.918 -27.263)" fill="#2a7de1"/>
												</svg>
									    	</a><?php
									    } ?>
								  	</div>
								 </div>
							</div><?php
						}
					} 
				} 
				if(!empty($simple_card) && $add_card == 1){ 
					pax_simple_card($simple_card);
				} ?>
			</div>
		</div><?php
	}
}

function pax_simple_card($simple_card) {
	if(!empty($simple_card)){ 
		$simple_card_color = $simple_card['simple_card_color'];
		$simple_card_section_header = $simple_card['simple_card_section_header'];
		$buttons = $simple_card['buttons'];
		$color_picker = $simple_card_color['color_picker']; 
		if (!empty($color_picker)) {
			$overlay_class = ' has-' . esc_attr( $color_picker ) . '-background-color';
		} ?>
		<div class="simple-card-main <?php echo $overlay_class; ?>">
			<div class="simple-card-outer">
				<div class="card"><?php
					if(!empty($simple_card_section_header)){
						pax_section_header($simple_card_section_header);
					}
					if(!empty($buttons)){ 
						foreach ( $buttons as $button ) {
							// Only display the button item if a URL is set.
							if ( ! empty( $button ) && ! empty( $button['button']['url'] ) ) {
								$button_class  = '';
								$button_target = '';
								$button_text_color_class = '';
								$button_style  = $button['button_style'];
								$button_color_style  = $button['button_color_style'];
								$button_text_color_theme  = $button['button_text_color_theme']['color_picker'];
								if($button_color_style == 'color'){
									$button_color  = $button['button_color']['color_picker'];
									$button_class = ' has-' . esc_attr( $button_color ) . '-background-color has-background';
								}
								else{
									$button_color  = $button['gradient'];
									$button_class = ' has-' . esc_attr( $button_color ) . '-gradient-background';
								}
								if ( ! empty( $button['button']['target'] ) ) {
									$button_target = ' target="' . esc_attr( $button['button']['target'] ) . '"';
								}
								if ( ! empty( $button_text_color_theme ) ) {
									$button_text_color_class = ' has-' . esc_attr( $button_text_color_theme ) . '-color has-text-color';
								}
								if ( ! empty( $button_color ) ) {
									switch ( $button_style ) {
										case 'outline':
											$button_class = ' has-outline-' . esc_attr( $button_color ) . '-color outline-color';
											break;
										case 'fill':
										default:
											$button_class;
											break;
									}
								} ?>
								<div class="wp-block-button is-style-<?php echo esc_attr( $button_style ); ?>">
									<a class="wp-block-button__link wp-element-button stretched-link <?php echo esc_attr( $button_class ); ?> <?php echo esc_attr( $button_text_color_class ); ?>"
									   href="<?php echo esc_url( $button['button']['url'] ); ?>"<?php echo $button_target; ?>>
										<?php esc_html_e( $button['button']['title'], THEME_TEXT_DOMAIN ); ?>
									</a>
								</div><?php
							}
						}
					} ?>
				</div>
			</div>
		</div><?php
	}
}


function pax_card_with_icon($cards, $simple_card, $add_card) {
	if(!empty($cards) || !empty($simple_card) && $add_card == 1){ ?>
		<div class="cards-with-icon">
			<div class="cards-icon"><?php
				if(!empty($cards)){
					foreach ( $cards as $card ){
						$icon = $card['icon'];
						$heading = $card['heading'];
						$content = $card['content'];
						$link = $card['link']; 
						if(!empty($icon) && !empty($icon['url']) || !empty($heading) || !empty($content) || !empty($link)){  ?>
							<div class="card"><?php
								if(!empty($icon) && !empty($icon['url'])){ ?>
									<div class="card-img">
							  			<img src="<?php echo esc_url($icon['url']); ?>" class="card-img-top" alt="<?php echo $icon['alt']; ?>">
							  		</div><?php
							  	} ?>
							  	<div class="card-body"><?php
							  		if(!empty($heading)){ ?>
								    	<h3 class="card-title"><?php echo $heading; ?></h3><?php
								    } 
								    if(!empty($content)){ ?>
								    	<p class="card-text"><?php echo $content; ?></p><?php
								    } 
								    if(!empty($link) && !empty($link['url'])){ ?>
								    	<a href="<?php echo esc_url($link['url']); ?>" class="custom-link stretched-link" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a><?php
								    } ?>
							  	</div>
							</div><?php
						}
					} 
				}
				if(!empty($simple_card) && $add_card == 1){ 
					pax_simple_card($simple_card);
				} ?>
			</div>
		</div><?php
	}
}

function pax_slider_postcards($cards) {
	if(!empty($cards)){
		$menu_counter = 0;  ?>
		<div class="tab-menu">
			<ul class="ul-include"><?php
				foreach ( $cards as $card ){
					$heading = $card['heading']; 
					if ($menu_counter == 0) {
						$active_class = ' active';
					} else {
						$active_class = '';
					} 
					if(!empty($heading)){ ?>
						<li>
							<a href="#" class="tab-wrap tab-<?php echo $menu_counter; ?><?php echo $active_class; ?>" data-rel="<?php echo $menu_counter; ?>"><?php echo $heading; ?></a>
						</li><?php
					}
					$menu_counter++;
				} ?>
			</ul>
		</div>
		<div class="postcards-slider-outer">
			<div class="swiper cards-postcards-slider postcards-card-main">
				<div class="swiper-wrapper postcards"><?php
					$tab_counter = 0;
					foreach ( $cards as $card ){
						$style = '';

						if ( $tab_counter == 0 ) {
							$style = ' style="display:block"';
						}
						$image = $card['image'];
						$heading = $card['heading'];
						$content = $card['content'];
						$buttons = $card['buttons_group']; 
						if(!empty($image) || !empty($heading) || !empty($content) || !empty($buttons)){ ?>
							<div id="tab-<?php echo $tab_counter; ?>" class="postcards-card swiper-slide" class="tab-box"<?php echo $style; ?>>
								<div class="postcards-slider-inner heading-colordark text-colordark"><?php
									if(!empty($image) && !empty($image['url'])){ ?>
										<div class="postcards-card-img-main">
								  			<img src="<?php echo esc_url($image['url']); ?>" class="postcards-card-img-top" alt="<?php echo esc_attr($image['alt']); ?>">
								  		</div><?php
								  	} ?>
								  	<div class="postcards-card-body"><?php
								  		if(!empty($heading)){ ?>
									    	<h3 class="postcards-card-title"><?php echo $heading; ?></h3><?php
									    } 
									    if(!empty($content)){ ?>
									    	<?php echo $content; ?><?php
									    } 
									    if(!empty($buttons)){ 
											pax_display_buttons($buttons); 
										} ?>
								  	</div>
							    </div>
							</div><?php
						}
						$tab_counter++;
					} ?>
				</div>
				<div class="swiper-button-next"></div>
	    		<div class="swiper-button-prev"></div>
    			<div class="swiper-pagination"></div>
			</div>
		</div><?php
	}
}

function pax_accordions($accordions) {
	if(!empty($accordions)){ ?>
		<div class="accordion-main">
			<div class="accordion "><?php
				foreach ( $accordions as $accordion ){
					foreach ( $accordion as $accordion_item ){
						$accordion_item_title = $accordion_item['accordion_item_title'];
						$accordion_item_content = $accordion_item['accordion_item_content']; 
						if(!empty($accordion_item_title) || !empty($accordion_item_content)){ ?>
							<div class="accordion-outer">
								<div class="accordion-item">
									<div class="accordion-title"><?php
										if(!empty($accordion_item_title)){ ?>
											<h3><?php echo $accordion_item_title; ?></h3><?php
										} ?>
									</div>
		    					</div><?php
		    					if(!empty($accordion_item_content)){ ?>
			    					<div class="accordion-contant" style="display: none;">
			    						<?php echo $accordion_item_content; ?>
			    					</div><?php
			    				} ?>
			    			</div><?php
			    		}
					}
				} ?>
			</div>
		</div><?php
	}
}

function pax_card_with_button($cards) {
	if(!empty($cards)){ ?>
		<div class="cards-with-button">
			<div class="cards-button"><?php
					foreach ( $cards as $card ){
						$icon = $card['icon'];
						$heading = $card['heading'];
						$content = $card['content'];
						$buttons = $card['buttons_group'];
						if(!empty($icon) || !empty($heading) || !empty($content) || !empty($buttons)){  ?>
							<div class="card"><?php
								if(!empty($icon) && !empty($icon['url'])){ ?>
									<div class="card-img">
							  			<img src="<?php echo esc_url($icon['url']); ?>" class="card-img-top" alt="<?php echo $icon['alt']; ?>">
							  		</div><?php
							  	} ?>
							  	<div class="card-body"><?php
							  		if(!empty($heading)){ ?>
								    	<h3 class="card-title"><?php echo $heading; ?></h3><?php
								    } 
								    if(!empty($content)){ ?>
								    	<p class="card-text"><?php echo $content; ?></p><?php
								    } ?>
							  	</div><?php
							  	if(!empty($buttons)){ 
									foreach ( $buttons as $button ) {
										// Only display the button item if a URL is set.
										if ( ! empty( $button ) && ! empty( $button['button']['url'] ) ) {
											$button_class  = '';
											$button_target = '';
											$button_text_color_class = '';
											$button_style  = $button['button_style'];
											$button_color_style  = $button['button_color_style'];
											$button_text_color_theme  = $button['button_text_color_theme']['color_picker'];
											if($button_color_style == 'color'){
												$button_color  = $button['button_color']['color_picker'];
												$button_class = ' has-' . esc_attr( $button_color ) . '-background-color has-background';
											}
											else{
												$button_color  = $button['gradient'];
												$button_class = ' has-' . esc_attr( $button_color ) . '-gradient-background';
											}
											if ( ! empty( $button['button']['target'] ) ) {
												$button_target = ' target="' . esc_attr( $button['button']['target'] ) . '"';
											}
											if ( ! empty( $button_text_color_theme ) ) {
												$button_text_color_class = ' has-' . esc_attr( $button_text_color_theme ) . '-color has-text-color';
											}
											if ( ! empty( $button_color ) ) {
												switch ( $button_style ) {
													case 'outline':
														$button_class = ' has-outline-' . esc_attr( $button_color ) . '-color outline-color';
														break;
													case 'fill':
													default:
														$button_class;
														break;
												}
											} ?>
											<div class="wp-block-button is-style-<?php echo esc_attr( $button_style ); ?>">
												<a class="wp-block-button__link wp-element-button stretched-link <?php echo esc_attr( $button_class ); ?> <?php echo esc_attr( $button_text_color_class ); ?>"
												   href="<?php echo esc_url( $button['button']['url'] ); ?>"<?php echo $button_target; ?>>
													<?php esc_html_e( $button['button']['title'], THEME_TEXT_DOMAIN ); ?>
												</a>
											</div><?php
										}
									}
								} ?>
							</div><?php
						}
					} ?>
			</div>
		</div><?php
	}
}

function pax_card_image_with_caption_link($cards) {
	if(!empty($cards)){ ?>
		<div class="card-with-image-caption-link-main">
			<div class="card-with-image-caption-link-outer"><?php
				foreach ( $cards as $card ){
					$card_image = $card['card_image'];
					$card_link = $card['card_link']; 
					if(!empty($card_image) && !empty($card_image['url']) || !empty($card_link)){ ?>
						<div class="card-caption-link-item"><?php
							if(!empty($card_image) && !empty($card_image['url'])){ ?>
								<div class="caption-image">
									<img src="<?php echo esc_url($card_image['url']); ?>" alt="<?php echo esc_attr($card_image['alt']); ?>">
								</div><?php
							} 
							if(!empty($card_link) && !empty($card_link['url'])){ ?>
								<div class="card-link">
									<a href="<?php echo esc_url($card_link['url']); ?>" class="caption-link" target="<?php echo $target['title']; ?>"><?php echo $card_link['title']; ?></a>
								</div><?php
							} ?>
						</div><?php
					}
				} ?>
			</div>
		</div><?php
	}
}

// Display the related reads
function related_reads( $exclude, $category_id) {
	$args = array(
		'category__in' => $category_id,
		'posts_per_page' => 3,
		'post_status' => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows' => true,
		'post__not_in' => array($exclude),
	);
	$recent_reads = new WP_Query( $args ); 
	if ( $recent_reads->have_posts() ) 
	{  ?>
		<div class="related-post-inner">
		    <div class="related-post-container">
		        <div class="related-post-inner-main"><?php
					while ( $recent_reads->have_posts() ) {
						$recent_reads->the_post(); 	?>			
						<div class="blog-list-items">
							<a href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) { ?>
									<div class="blog_img">
										<?php pax_post_thumbnail(); ?>
									</div>
								<?php } ?>
								<div class="blog-block-bottom">
									<div class="blog_content">
										<h2 class="blog_heading"><?php echo get_the_title(); ?></h2>
									</div>
									<div class="blog-button-bottom">
										<div class="bottom-date-btn text-right">
											<span class="common-btn sbtn-view">
												Read
												<svg xmlns="http://www.w3.org/2000/svg" width="9.59" height="11.371" viewBox="0 0 9.59 11.371"><path id="Path_55163" data-name="Path 55163" d="M6.98,32.948.918,27.263H5.985l3.7,3.7a2.806,2.806,0,0,1,0,3.969l-3.7,3.7H.918Z" transform="translate(-0.918 -27.263)" fill="#2a7de1"></path>
						                                        </svg>
											</span>
										</div>
									</div>
								</div>
							</a>
						</div><?php
					}
					wp_reset_postdata(); ?>
				</div>
			</div>
		</div><?php
	} 
}

function pax_card_with_colored_content($cards, $simple_card, $add_card) {
	if(!empty($cards) || !empty($simple_card) && $add_card == 1){ ?>
		<div class="card-with-colored-content-main">
			<div class="card-with-colored-content-outer"><?php
				if(!empty($cards)){
					foreach ( $cards as $card ){
						$image = $card['image'];
						$heading = $card['heading']; 
						$content = $card['content']; 
						if(!empty($image) && !empty($image['url']) || !empty($heading) || !empty($content)){ ?>
							<div class="card-caption-colored-item"><?php
								if(!empty($image)){ ?>
									<div class="colored-content-image">
										<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
									</div><?php
								} ?>
								<div class="colored-content-text"><?php
									if(!empty($heading)){ ?>
										<h3><?php echo $heading; ?></h3><?php
									} 
									if(!empty($content)){ ?>
										<div class="colored-content">
											<?php echo $content; ?>
										</div><?php
									} ?>
								</div>
							</div><?php
						}
					}
				}
				if(!empty($simple_card) && $add_card == 1){ 
					pax_simple_card($simple_card);
				}  ?>
			</div>
		</div><?php
	}
}

function pax_columns_with_repeater($columns) {
	if(!empty($columns)){ ?>
		<div class="columns-with-colored-content-main">
			<div class="columns-with-colored-content-outer"><?php
				foreach ( $columns as $column ){
					$icon = $column['icon'];
					$heading = $column['heading']; 
					$content = $column['content']; 
					$link = $column['link']; 
					if(!empty($icon) && !empty($icon['url']) || !empty($heading) || !empty($content) || !empty($link)){ ?>
						<div class="columns-caption-colored-item"><?php
							if(!empty($icon)){ ?>
								<div class="columns-content-icon">
									<img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
								</div><?php
							} 
							if(!empty($heading)){ ?>
								<h3><?php echo $heading; ?></h3><?php
							} 
							if(!empty($content)){ ?>
								<div class="columns-content">
									<?php echo $content; ?>
								</div><?php
							} 
							if(!empty($link) && !empty($link['url'])){ ?>
								<div class="link">
									<a href="<?php echo esc_url($link['url']); ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a>
								</div><?php
							} ?>
						</div><?php
					}
				} ?>
			</div>
		</div><?php
	}
}

function pax_card_with_image_overlay($card) {
	if(!empty($card)){ ?>
		<div class="card-with-image-overlay-main">
			<div class="card-with-image-overlay-outer"><?php
				$heading = $card['heading'];
				$content = $card['content']; 
				$buttons = $card['buttons_group']; 
				if(!empty($heading) || !empty($content) || !empty($buttons )){ ?>
					<div class="image-overlay-card"><?php
						if(!empty($heading)){ ?>
							<h3><?php echo $heading; ?></h3><?php
						} 
						if(!empty($content)){ ?>
							<div class="overlay-card-content">
								<?php echo $content; ?>
							</div><?php
						}  
						if(!empty($buttons)){
							pax_display_buttons($buttons);
						} ?>
					</div><?php
				} ?>
			</div>
		</div><?php
	}
}

function pax_cards_with_logos_repeater($cards) {
	if(!empty($cards)){ ?>
		<div class="cards-with-logos-repeater-main">
			<div class="cards-with-logos-repeater-outer"><?php
				foreach ( $cards as $card ){
					$logo = $card['logo'];
					$heading = $card['heading']; 
					$content = $card['content']; 
					$link = $card['link']; 
					if(!empty($logo) && !empty($logo['url']) || !empty($heading) || !empty($content) || !empty($link)){ ?>
						<div class="cards-caption-logos-item"><?php
							if(!empty($logo)){ ?>
								<div class="cards-repeater-logo">
									<img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
								</div><?php
							} ?>
							<div class="cards-caption-text">
								<div class="cards-caption-text-inner"><?php
									if(!empty($heading)){ ?>
										<h3><?php echo $heading; ?></h3><?php
									} 
									if(!empty($content)){ ?>
										<div class="cards-repeater">
											<?php echo $content; ?>
										</div><?php
									} ?>
								</div><?php
								if(!empty($link) && !empty($link['url'])){ ?>
									<div class="link">
										<a href="<?php echo esc_url($link['url']); ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?> 
											<svg xmlns="http://www.w3.org/2000/svg" width="9.59" height="11.371" viewBox="0 0 9.59 11.371"><path id="Path_55163" data-name="Path 55163" d="M6.98,32.948.918,27.263H5.985l3.7,3.7a2.806,2.806,0,0,1,0,3.969l-3.7,3.7H.918Z" transform="translate(-0.918 -27.263)" fill="#2a7de1"/>
											</svg>
										</a>
									</div><?php
								} ?>
							</div>
						</div><?php
					}
				} ?>
			</div>
		</div><?php
	}
}

function pax_promo_postcard($tagline, $heading, $content, $buttons, $image) { 
	if(!empty($tagline) || !empty($heading) || !empty($content) || !empty($buttons) || !empty($image)){  ?>
		<div class="promo-postcard-main">
			<div class="promo-postcard-outer"><?php
				if(!empty($tagline) || !empty($heading) || !empty($content) || !empty($buttons)){ ?>
					<div class="promo-postcard-content">
						<div class="promo-postcard-content-inner"> <?php
							if(!empty($tagline)){ ?>
								<label><?php echo $tagline; ?></label><?php
							} 
							if(!empty($heading)){ ?>
								<h5><?php echo $heading; ?></h5><?php
							} 
							if(!empty($content)){ ?>
								<p><?php echo $content; ?></p><?php
							} ?>
						</div><?php
						if(!empty($buttons)){ ?>
							<div class="promo-postcard-button">
								<?php pax_display_buttons($buttons); ?>
							</div><?php
						} ?>
					</div><?php
				}
				if(!empty($image) && !empty($image['url'])){ ?>
					<div class="promo-postcard-image">
						<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
					</div><?php
				} ?>
			</div>
		</div><?php
	}
}