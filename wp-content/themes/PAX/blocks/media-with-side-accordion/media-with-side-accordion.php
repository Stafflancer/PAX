<?php
/**
 * Media with Side Accordion
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$section_header = get_field('section_header');
$media_type = get_field('media_type');
$image = get_field('image');
$video = get_field('video');
$accordions = get_field('accordion');
$buttons = get_field('buttons_group');
$accordion_heading_color = get_field('accordion_heading_color');
if(!empty($video)){
	$video_embed = $video;
	preg_match('/src="(.+?)"/', $video_embed, $matches);
	$src = $matches[1];
	$params = array(
		'controls'  => 1,
		'hd'        => 1,
	);
	$new_src = add_query_arg($params, $src);
	$iframe = str_replace($src, $new_src, $video_embed);

	$attributes = 'frameborder="0"';
	$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
}
// Create id attribute allowing for custom "anchor" value.
$id = 'media-with-side-accordion' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'media-with-side-accordion';

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
	<div class="media-with-side-accordion-main">
		<div class="media-with-side-accordion-outer"><?php
            if(!empty($section_header)){ ?>
                <div class="postcards-section-header">
                    <?php pax_section_header($section_header); ?>
                </div><?php
            } ?>
            <div class="media-with-side-outer <?php echo 'accordion-heading-color-'.$accordion_heading_color; ?>">
				<div class="media-section-image"><?php
					if($media_type == 'image'){
						if(!empty($image)){?>
							<div class="image">
								<?php echo wp_get_attachment_image($image, $size = 'full'); ?>
							</div><?php
						} 
					} 
					else{ 
						if(!empty($video)){ ?>
							<div class="video">
								<?php echo $iframe; ?>
							</div><?php
						}
					} ?>
				</div><?php
				if(!empty($accordions)){ ?>
					<?php pax_accordions($accordions); ?>
					<?php
				}?>
			</div><?php
			if(!empty($buttons)){ ?>
	            <div class="postcards-button">
	                <?php pax_display_buttons($buttons); ?>
	            </div><?php
        	}  ?>
		</div>
	</div><?php
pax_close_block( $container_args['container'] );