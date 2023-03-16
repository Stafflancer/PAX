<?php
/**
 * Slider - Postcards
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$section_header = get_field('section_header');
$cards = get_field('cards');
$buttons = get_field('buttons_group');

// Create id attribute allowing for custom "anchor" value.
$id = 'slider-postcards-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className".
$section_class_name = 'slider-postcards';

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
    <div class="slider-postcards-outer"><?php
        if(!empty($section_header)){ ?>
            <div class="postcards-section-header">
                <?php pax_section_header($section_header); ?>
            </div><?php
        } ?> <?php
        if(!empty($cards)){ ?>
                <div class="postcards">
                    <?php pax_slider_postcards($cards); ?>
                </div><?php
        }
        if(!empty($buttons)){ ?>
            <div class="postcards-button">
                <?php pax_display_buttons($buttons); ?>
            </div><?php
        } ?>
    </div><?php  
pax_close_block( $container_args['container'] );
