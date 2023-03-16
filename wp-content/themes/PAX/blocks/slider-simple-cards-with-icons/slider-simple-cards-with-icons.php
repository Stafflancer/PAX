<?php
/**
 * Slider - Simple Cards with Icons
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$section_header = get_field('section_header');

// Create id attribute allowing for custom "anchor" value.
$id = 'slider-simple-cards-with-icons' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'slider-simple-cards-with-icons';

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
	<div class="slider-simple-cards-with-icons-inner"><?php 
		if(!empty($section_header)){
			pax_section_header($section_header);
		} 
		if(have_rows('cards')){ ?>
			<div class="slider-simple-cards-with-icons-outer">
				<div class="swiper slider-simple-card-main slider-simple-card-slider">
					<div class="swiper-wrapper"><?php
						while(have_rows('cards')){
							the_row();
							$icon = get_sub_field('icon');
							$heading = get_sub_field('heading');
							$content = get_sub_field('content');
							$link = get_sub_field('link'); ?>
							<div class="slider-card-item swiper-slide">
								<div class="card-inner">
									<?php
									if(!empty($link) && !empty($link['url'])){ ?>
										<a href="<?php echo esc_url($link['url']); ?>"><?php
									} 
										if(!empty($icon) && !empty($icon['url'])){ ?>
											<div class="card-img">
												<img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
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
									if(!empty($link) && !empty($link['url'])){ ?>
										</a><?php
									} ?>
								</div>
							</div><?php
						} ?>
					</div>
					<div class="swiper-button-next"></div>
	    			<div class="swiper-button-prev"></div>
	    			<div class="swiper-pagination"></div>
				</div>
			</div><?php
		} ?>
	</div><?php
pax_close_block( $container_args['container'] );