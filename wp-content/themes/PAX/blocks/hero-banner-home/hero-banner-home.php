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

$tagline = get_field('tagline');
$heading = get_field('heading');
$image = get_field('image');
$buttons = get_field( 'buttons');
$video = get_field('modal_video');
$add_indicator = get_field('add_indicator');
$indicator_icon = get_field('indicator_icon');

// Create id attribute allowing for custom "anchor" value.
$id = 'hero-home-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className".
$section_class_name = 'hero-banner-home';

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
	<div class="hero-banner-outer">
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
				if(!empty($tagline)){ ?>
					<div class="banner-tagline">
						<p class="h1"><?php echo $tagline; ?></p>
					</div><?php

				}
				if($buttons){
				    pax_display_buttons($buttons);
				} 
				$button_title  = $video['button_title'];
				$video_icon = $video['video_icon'];
				if ( !empty($button_title) || !empty($video_icon) && !empty($video_icon['url'])) { ?>
					<div class="footer-form-heading">
						<a href="javascript:void(0);" class="play-video"><?php
							if(!empty($video_icon) && !empty($video_icon['url'])){ ?>
								<img src="<?php echo esc_url($video_icon['url']); ?>"><?php
							} ?>
							<span><?php echo $button_title; ?></span>
						</a>
					</div><?php
				} ?>
			</div>
		</div>
		<div class="hero-banner-right"><?php
			if( !empty($image) &&  !empty( $image['url']) ) {?>
			    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" /><?php 
			} ?>
		</div>
	</div><?php
	
pax_close_block( $container_args['container'] );
if(!empty($video)){
	pax_modal_video($video );
} 