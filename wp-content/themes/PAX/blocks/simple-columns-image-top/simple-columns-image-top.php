<?php
/**
 * Simple Columns (Image Top) Block Template.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$section_header = get_field('section_header');
$image = get_field('image');
$buttons = get_field('buttons_group');
$card_per_row = get_field('card_per_row'); 
if(have_rows('columns')){
	// Create id attribute allowing for custom "anchor" value.
	$id = 'simple-columns-image-top' . $block['id'];

	if ( ! empty( $block['anchor'] ) ) {
		$id = $block['anchor'];
	}


	// Create class attribute allowing for custom "className".
	$section_class_name = 'simple-columns-image-top';

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
		if(!empty($image) && !empty($image['url'])){ ?>
			<div class="columns-image">
				<img src="<?php echo esc_url($image['url']); ?>">
			</div><?php
		} ?>
		<div class="columns-outer <?php echo 'per-row-'.$card_per_row; ?>"><?php
			while(have_rows('columns')){
				the_row(); 
				$image = get_sub_field('image');
				$heading = get_sub_field('heading');
				$content = get_sub_field('content');
				$link = get_sub_field('link'); ?>
				<div class="columns-item"><?php
					if(!empty($image) && !empty($image['url'])){ ?>
					  	<img src="<?php echo esc_url($image['url']); ?>" class="columns-img-top" alt="<?php echo $image['alt']; ?>"><?php
					} ?>
					<div class="columns-body"><?php
					  	if(!empty($heading)){ ?>
						    <h4 class="columns-title"><?php echo $heading; ?></h4><?php
						} 
						if(!empty($content)){ ?>
						   	<p class="columns-text"><?php echo $content; ?></p><?php
						} 
						if(!empty($link) && !empty($link['url'])){ ?>
						    <a href="<?php echo esc_url($link['url']); ?>" class="custom-link" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a><?php
					   	} ?>
					</div>
				</div><?php
			} ?>
		</div><?php
		if(!empty($buttons)){
			pax_display_buttons($buttons);
		}
	pax_close_block( $container_args['container'] );
}