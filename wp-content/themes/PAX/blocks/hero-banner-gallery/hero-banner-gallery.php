<?php
/**
 * Hero Banner - Gallery
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'hero-banner-gallery-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className".
$section_class_name = 'hero-banner-gallery';

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
		<div class="hero-banner-side">
			<div class="breadcrumb"><?php
				pax_display_breadcrumbs(); ?>
			</div><?php
			if(have_rows('content')){ ?>
				<div class="hero-banner-gallery-content"><?php
					while(have_rows('content')){
						the_row();
						$heading = get_sub_field('heading');
						$subheading = get_sub_field('subheading');
						$content = get_sub_field('content');
						$add_indicator = get_sub_field('add_indicator'); 
						$indicator_icon = get_sub_field('indicator_icon');  ?>
						<div class="gallery-content-item"><?php
							if($add_indicator == 1 && !empty($indicator_icon) && !empty($indicator_icon['url'])){ ?>
								<div class="add-indicato" style="background-image: url(<?php echo esc_url($indicator_icon['url']); ?>);"></div><?php
							} ?>
							<div class="gallery-content-item-inner"><?php
								if(!empty($heading)){ ?>
									<h1><?php echo $heading; ?></h1><?php
								} 
								if(!empty($subheading)){ ?>
									<h3><?php echo $subheading; ?></h3><?php
								} 
								if(!empty($content)){ ?>
									<div class="content">
										<?php echo $content; ?>
									</div><?php
								} ?>
							</div>
						</div><?php
					} ?>
				</div><?php
			} ?>
		</div><?php
		if(have_rows('media')){ ?>
			<div class="side-image">
				<div class="side-image-inner"><?php
					while(have_rows('media')){
						the_row();
						$gallery = get_sub_field('gallery');
						$buttons = get_sub_field('buttons_group'); ?>
						<div class="gallery swiper hero-banner-gallery-slider"><?php 
								if( $gallery ){ ?>
								    <ul class="swiper-wrapper"><?php 
								    	foreach( $gallery as $image ){ ?>
								            <li class="swiper-slide">
								                <a href="<?php echo esc_url($image['url']); ?>">
								                     <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
								                </a>
								                <p><?php echo esc_html($image['caption']); ?></p>
								            </li><?php
								        } ?>
								    </ul><?php
								} ?>
							<div class="swiper-button-next"></div>
		    				<div class="swiper-button-prev"></div>
						</div><?php
						if(!empty($buttons)){
							pax_display_buttons($buttons);
						}
					} ?>
				</div>
			</div><?php
		}?>
	</div><?php
pax_close_block( $container_args['container'] );