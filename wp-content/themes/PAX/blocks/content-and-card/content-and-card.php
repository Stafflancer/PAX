<?php
/**
 * Content + Card
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$content_left = get_field('content_left');
$content_right = get_field('content_right');

// Create id attribute allowing for custom "anchor" value.
$id = 'content-and-card' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'content-and-card';

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
	if(!empty($content_left) || !empty($content_right)){ ?>
		<div class="contant-card"><?php
			if(!empty($content_left)){ ?>
				<div class="left-content">
					<?php echo $content_left; ?>
				</div><?php
			} 
			if(!empty($content_right)){ ?>
				<div class="right-content">
					<?php echo $content_right; ?>
				</div><?php
			} ?>
		</div><?php
	}
pax_close_block( $container_args['container'] );