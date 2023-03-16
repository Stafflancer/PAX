<?php
/**
 * Promo Postcard
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$tagline = get_field('tagline');
$heading = get_field('heading');
$content = get_field('content');
$buttons = get_field('buttons_group');
$image = get_field('image');

// Create id attribute allowing for custom "anchor" value.
$id = 'promo-postcard' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'promo-postcard';

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
	if(!empty($tagline) || !empty($heading) || !empty($content) || !empty($buttons) || !empty($image)){ 
		pax_promo_postcard($tagline, $heading, $content, $buttons, $image);
	}
pax_close_block( $container_args['container'] );