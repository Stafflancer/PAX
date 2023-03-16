<?php
/**
 * CTA - Side by Side (Cards)
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'cta-side-by-side-cards' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'cta-side-by-side-cards';

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
	$image = get_field('image'); ?>
	<div class="cta-side-by-side-cards-inner"><?php
		if(have_rows('content')){ ?>
			<div class="cta-heading-content"><?php
				while(have_rows('content')){
					the_row();
					$section_header = get_sub_field('section_header');
					$buttons_group = get_sub_field('buttons_group');
					$image = get_sub_field('image'); 
					if(!empty($image) && !empty($image['url'])){ ?>
						<div class="image-card">
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
						</div><?php
					}
					if(!empty($section_header)){
						pax_section_header($section_header);
					}
					if(!empty($buttons_group)){
						pax_display_buttons($buttons_group);
					}
				} ?>
			</div>
			<?php
		} 
		$form = get_field('form'); 
		if(!empty($form)){ ?>
				<div class="form">
					<?php echo do_shortcode( '[gravityform id="' . $form . '" title="false" ajax="true"]' ); ?>
				</div><?php
		} ?>
	</div><?php	
pax_close_block( $container_args['container'] );