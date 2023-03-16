<?php
/**
 * Cards with Image + Pattern Repeater
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
$add_card = get_field('add_card');
$simple_card = get_field('simple_card');
$buttons = get_field('buttons_group');

// Create id attribute allowing for custom "anchor" value.
$id = 'cards-with-image-pattern-repeater' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'cards-with-image-pattern-repeater';

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
	if(!empty($section_header)){
		pax_section_header($section_header);
	}
	if(!empty($cards) || !empty($simple_card) && $add_card == 1){ 
		pax_cards_with_image_pattern($cards, $simple_card, $add_card);
	}
	if(!empty($buttons)){
		pax_display_buttons($buttons);
	}
pax_close_block( $container_args['container'] );