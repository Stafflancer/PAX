<?php
/**
 * Hero Banner - Simple Block Template.
 *
 * @param array        $block      The block settings and attributes.
 * @param string       $content    The block inner HTML (empty).
 * @param bool         $is_preview True during AJAX preview.
 * @param (int|string) $post_id    The post ID this block is saved to.
 *
 * @package PAX
 */

$heading = get_field( 'heading' );

if ( ! empty( $heading ) ) {
	// Create id attribute allowing for custom "anchor" value.
	$id = 'hero-banner-simple-' . $block['id'];

	if ( ! empty( $block['anchor'] ) ) {
		$id = $block['anchor'];
	}

	// Create class attribute allowing for custom "className".
	$section_class_name = 'hero-banner-simple';

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
	?>
	<div class="hero-banner-outer">
		<h1><?php echo $heading; ?></h1>
	</div>
	<?php
	pax_close_block( $container_args['container'] );
}