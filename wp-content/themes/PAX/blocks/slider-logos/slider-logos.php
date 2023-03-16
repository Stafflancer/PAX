<?php
/**
 * Slider - Logos Template.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$heading = get_field('heading');
$content = get_field('content');
$logos = get_field('logos');

if(!empty($logos)){
    // Create id attribute allowing for custom "anchor" value.
    $id = 'slider-logos-' . $block['id'];

    if ( ! empty( $block['anchor'] ) ) {
    	$id = $block['anchor'];
    }

    // Create class attribute allowing for custom "className".
    $section_class_name = 'slider-logos';

    if ( ! empty( $block['className'] ) ) {
    	$section_class_name .= ' ' . $block['className'];
    }

    // Start a <container> with possible block options.
    $container_args = [
    	'container' => 'section', // Any HTML5 container: section, div, etc...
    	'id'        => $id, // Container id.
    	'class'     => $section_class_name, // Container class.
    ];

    pax_display_block_background_options( $block, $container_args );
        if(!empty($heading)){ ?>
        	<div class="slider-heading">
        		<h2 class="h5"><?php echo $heading; ?></h2>
        	</div><?php

        }
        if(!empty($content)){ ?>
        	<div class="slider-content">
        		<p><?php echo $content; ?></p>
        	</div><?php

        }
        if(!empty($logos)){ 
            $size = 'full'; ?>
            <div class="slider-logos-main swiper swiper-container slider-logos-swiper">
                <div class="swiper-wrapper"><?php
                    foreach( $logos as $image_id ){ ?>
                        <div class="slider-logos-item swiper-slide">
                            <?php echo wp_get_attachment_image( $image_id, $size ); ?>
                        </div><?php
                    } ?>
                </div>
            </div><?php
        } ?><?php
    pax_close_block( $container_args['container'] );
}