<?php
/**
 * CTA - Single Column Block Template.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$column_position = get_field('column_position');
$section_header = get_field('section_header');
$buttons = get_field('buttons_group');

// Create id attribute allowing for custom "anchor" value.
$id = 'cta-single-column' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'cta-single-column';

if ( ! empty( $block['className'] ) ) {
	$section_class_name .= ' ' . $block['className'];
}

// Start a <container> with possible block options.
$container_args = [
	'container' => 'section', // Any HTML5 container: section, div, etc...
	'id'        => $id, // Container id.
	'class'     => $section_class_name, // Container class.
];

pax_display_block_background_options( $block, $container_args );?>
	<div class="columns-content-single <?php echo 'column-position-'.$column_position; ?>"><?php
		if(!empty($section_header)){
			pax_section_header($section_header);
		}
		if(!empty($buttons)){
			pax_display_buttons($buttons);
		} ?>
	</div><?php
pax_close_block( $container_args['container'] );