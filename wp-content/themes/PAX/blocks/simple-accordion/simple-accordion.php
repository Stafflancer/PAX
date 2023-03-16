<?php
/**
 * Simple Accordion
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$section_header = get_field('section_header');
$accordions = get_field('accordion');
$accordion_heading_color = get_field('accordion_heading_color');

// Create id attribute allowing for custom "anchor" value.
$id = 'simple-accordion' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'simple-accordion';

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
	<div class="simple-accordion-main">
		<div class="simple-accordion-outer <?php echo 'accordion-heading-color-'.$accordion_heading_color; ?>"><?php
            if(!empty($section_header)){ ?>
                <div class="postcards-section-header">
                    <?php pax_section_header($section_header); ?>
                </div><?php
            }
			if(!empty($accordions)){ ?>
					<?php pax_accordions($accordions); ?><?php
			} ?>
		</div>
	</div><?php
pax_close_block( $container_args['container'] );