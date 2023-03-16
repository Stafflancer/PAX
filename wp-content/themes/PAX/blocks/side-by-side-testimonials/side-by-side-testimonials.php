<?php
/**
 * Side by Side (Testimonials)
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'side-by-side-testimonials' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className".
$section_class_name = 'side-by-side-testimonials';

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
	<div class="icon-content-info"><?php
		if(have_rows('content_left')){ ?>
			<div class="content-left"><?php
				while(have_rows('content_left')){
					the_row();
					$section_header = get_sub_field('section_header');
					$buttons = get_sub_field('buttons_group'); ?>
					<div class="content-left-info"><?php
						if(!empty($section_header)){
							pax_section_header($section_header);
						} 
						if(!empty($buttons)){
							pax_display_buttons($buttons);
						} ?>
					</div><?php
				} ?>
			</div><?php
		} 
		if(have_rows('content_right')){ ?>
			<div class="content-right"><?php
				while(have_rows('content_right')){
					the_row();
					$header = get_sub_field('header');
					$testimonials = get_sub_field('testimonials'); ?>
					<div class="content-item">
						<div class="rating-star">
							<svg xmlns="http://www.w3.org/2000/svg" width="154" height="23.623" viewBox="0 0 154 23.623">
							  <g id="Icon-Stars" transform="translate(0)">
							    <path id="Path_57279" data-name="Path 57279" d="M12.42,0,8.581,7.776,0,9.023l6.211,6.052L4.743,23.623,12.42,19.59,20.1,23.623l-1.468-8.549L24.84,9.023,16.258,7.776Z" transform="translate(0 0)" fill="#f4cc25"/>
							    <path id="Path_57280" data-name="Path 57280" d="M25.157,0,21.318,7.776,12.736,9.023l6.209,6.052L17.48,23.623l7.677-4.034,7.677,4.034-1.468-8.549,6.211-6.052L28.995,7.776Z" transform="translate(19.554 0)" fill="#f4cc25"/>
							    <path id="Path_57281" data-name="Path 57281" d="M37.892,0,34.054,7.776,25.472,9.023l6.211,6.052-1.468,8.549,7.677-4.034,7.677,4.034L44.1,15.075l6.209-6.052L41.731,7.776Z" transform="translate(39.106 0)" fill="#f4cc25"/>
							    <path id="Path_57282" data-name="Path 57282" d="M50.629,0,46.791,7.776,38.209,9.023l6.209,6.052-1.465,8.549,7.677-4.034,7.677,4.034-1.468-8.549,6.211-6.052L54.468,7.776Z" transform="translate(58.66 0)" fill="#f4cc25"/>
							    <path id="Path_57283" data-name="Path 57283" d="M63.366,0,59.528,7.776,50.946,9.023l6.209,6.052-1.465,8.549,7.677-4.034Z" transform="translate(78.214 0)" fill="#f4cc25"/>
							    <path id="Path_57284" data-name="Path 57284" d="M59.028,15.4l.172-.986-.717-.695L55.03,10.349l4.769-.69.991-.145.441-.9L63.366,4.3,65.5,8.617l.441.9.991.145,4.769.69-3.453,3.367-.715.695.17.986.814,4.751L64.248,17.9l-.882-.464-.885.464-4.267,2.244ZM63.366,0,59.528,7.776,50.946,9.023l6.209,6.052-1.465,8.549,7.677-4.034,7.677,4.034-1.468-8.549,6.211-6.052L67.2,7.776Z" transform="translate(78.214)" fill="#f4cc25"/>
							  </g>
							</svg>
						</div><?php
						if(!empty($header)){ ?>
							<h2><?php echo $header; ?></h2><?php
						} ?>
						<div class="swiper swiper-container testimonials-slider">
							<div class="swiper-wrapper"><?php 
								if(!empty($testimonials)){ 
									foreach($testimonials as $testimonial){ 
										$testimonial = $testimonial['testimonial']; 
										if(!empty($testimonial)){ ?>
											<div class="testimonials-item swiper-slide">
												<blockquote><?php echo $testimonial; ?></blockquote>
											</div><?php
										} 
									} 
								} ?>
							</div>
							<div class="swiper-pagination"></div>
						</div>
					</div><?php
				} ?>
			</div><?php
		} ?>
	</div><?php
pax_close_block( $container_args['container'] );