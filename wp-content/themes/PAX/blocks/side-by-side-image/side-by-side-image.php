<?php
/**
 * Side by Side (Image) Block Template.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$column_order = get_field('column_order');
$image = get_field('image');

// Create id attribute allowing for custom "anchor" value.
$id = 'side-by-side-image' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'side-by-side-image';

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
	<div class="side-by-side-image-main <?php echo $column_order; ?>">
		<div class="side-by-side-image-outer"><?php
			if(!empty($image)){?>
				<div class="image">
					<?php echo wp_get_attachment_image($image, $size = 'full'); ?>
				</div><?php
			} ?><?php
			if(have_rows('content_group')){ ?>
				<div class="content-info">
					<div class="content-info-inner"><?php
						while(have_rows('content_group')){ 
							the_row();
							$section_header = get_sub_field('section_header');
							$buttons = get_sub_field('buttons_group');
							if(!empty($section_header)){
								pax_section_header($section_header);
							}
							if(!empty($buttons)){
								pax_display_buttons($buttons);
							} 
						} ?>
					</div>
				</div><?php
			} ?>
		</div>
	</div><?php
pax_close_block( $container_args['container'] );