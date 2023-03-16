<?php
/**
 * CTA - Promo Bar
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */


$heading = get_field('heading'); 
$buttons = get_field('button_group');
if($heading || $buttons){

	// Create id attribute allowing for custom "anchor" value.
	$id = 'cta-promo-bar' . $block['id'];

	if ( ! empty( $block['anchor'] ) ) {
		$id = $block['anchor'];
	}


	// Create class attribute allowing for custom "className".
	$section_class_name = 'cta-promo-bar';

	if ( ! empty( $block['className'] ) ) {
		$section_class_name .= ' ' . $block['className'];
	}



	// Start a <container> with possible block options.
	$container_args = [
		'container' => 'section', // Any HTML5 container: section, div, etc...
		'id'        => $id, // Container id.
		'class'     => $section_class_name, // Container class.
	];

	pax_display_block_background_options( $block, $container_args ); ?>
		<div class="cta-promo-bar-main">
	        <div class="cta-promo-bar-inner"><?php
	            if($heading){ ?>
	                <h3><?php echo $heading; ?></h3><?php
	            } 
	            if(!empty($buttons)){ ?>
					<div class="promo-postcard-button"><?php
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
												<a class="wp-block-button__link wp-element-button stretched-link <?php echo esc_attr( $button_class ); ?> <?php echo esc_attr( $button_text_color_class ); ?>"
												   href="<?php echo esc_url( $button['button']['url'] ); ?>"<?php echo $button_target; ?>>
													<?php esc_html_e( $button['button']['title'], THEME_TEXT_DOMAIN ); ?>
												</a>
											</div>
										<?php
									endif;
								endforeach; ?>
							</div>
						<?php endif; ?>
					</div><?php
				} ?>
	        </div>
	    </div><?php
	pax_close_block( $container_args['container'] );
}