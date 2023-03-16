<?php
/**
 * Hero Banner - Home Block Template.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$breadcrumb = get_field('breadcrumb');

// Create id attribute allowing for custom "anchor" value.
$id = 'hero-banner-form-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className".
$section_class_name = 'hero-banner-form';

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
	if($breadcrumb == 1){ ?>
		<div class="breadcrumb"><?php
			pax_display_breadcrumbs(); ?>
		</div><?php
	}?>
	<div class="hero-banner-outer"><?php
		if(have_rows('content')){ 
			while(have_rows('content')){
				the_row();
				$heading = get_sub_field('heading');
				$content = get_sub_field('content'); 
				$buttons = get_sub_field('buttons_group');
				$add_indicator = get_sub_field('add_indicator');
				$indicator_icon = get_sub_field('indicator_icon'); ?>
				<div class="hero-banner-left">
					<div class="hero-text-innner"><?php
						if($add_indicator == 1 && !empty($indicator_icon) && !empty($indicator_icon['url'])){ ?>
							<div class="add-indicato" style="background-image: url(<?php echo esc_url($indicator_icon['url']); ?>);"></div><?php
						} 
						if(!empty($heading)){ ?>
							<div class="banner-heading">
								<h1><?php echo $heading; ?></h1>
							</div><?php

						}
						if(!empty($content)){ ?>
							<div class="banner-content">
								<?php echo $content; ?>
							</div><?php

						}
						if($buttons){
						    pax_display_buttons($buttons);
						} ?>
					</div>
				</div><?php
			}
		} 
		$form = get_field('form'); 
		if(!empty($form)){ ?>
			<div class="hero-banner-form-inner">
				<?php echo do_shortcode( '[gravityform id="' . $form . '" title="false" ajax="true"]' ); ?>
			</div><?php
		} ?>
	</div><?php
	
pax_close_block( $container_args['container'] );