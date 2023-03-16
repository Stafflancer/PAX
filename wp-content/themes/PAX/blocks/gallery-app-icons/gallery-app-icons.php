<?php
/**
 * Gallery - App Icons Block Template.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$section_header = get_field('section_header');
$buttons_group = get_field('buttons_group');

// Create id attribute allowing for custom "anchor" value.
$id = 'gallery-app-icons' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'gallery-app-icons';

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
	if(have_rows('icon_rows')){ 
		$size = "full";?>
		<div class="icon-rows"><?php
		while(have_rows('icon_rows')){
			the_row();
			$app_icons = get_sub_field('app_icons'); 
			if(!empty($app_icons)){ ?>
				<div class="icon-item-outer"><?php
				foreach($app_icons as $image_id){ ?>
					<div class="icons">
						<?php echo wp_get_attachment_image( $image_id, $size ); ?>
					</div><?php
				} ?>
				</div><?php
			}
		} ?>
		</div><?php
	}
	if(!empty($buttons_group)){
		pax_display_buttons($buttons_group);
	}
pax_close_block( $container_args['container'] );