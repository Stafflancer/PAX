<?php
/**
 * Postcard - Headquarters
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$image = get_field('image');
$main_heading = get_field('main_heading');
$address_heading = get_field('address_heading');
$address = get_field('address');

// Create id attribute allowing for custom "anchor" value.
$id = 'postcard-headquarters' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'postcard-headquarters';

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
	<div class="postcard-headquarters-content"><?php
		if(!empty($main_heading)){ ?>
			<h2><?php echo $main_heading; ?></h2><?php
		} ?>
		<div class="postcard-headquarters-outer"><?php
			if(!empty($image) && !empty($image['url'])){ ?>
				<div class="postcard-headquarters-image">
					<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
				</div><?php
			} ?>
			<div class="headquarters-info"><?php 
				if(!empty($address_heading)){ ?>
					<h3><?php echo $address_heading; ?></h3><?php
				} 
				if(!empty($address)){ ?>
					<div class="headquarters">
						<?php echo $address; ?>
					</div><?php
				} 
				if(have_rows('contacts')){ ?>
					<div class="contacts"><?php
						while(have_rows('contacts')){
							the_row();
							$title = get_sub_field('title');
							$link = get_sub_field('link'); ?>
							<h6><?php
								if(!empty($title)){ ?>
									<span><?php echo $title.':'; ?></span><?php
								}
								if(!empty($link) && !empty($link['url'])){ ?>
									<a href="<?php echo esc_url($link['url']); ?>"><?php echo $link['title']; ?></a><?php
								} ?> 
							</h6><?php
						} ?>
					</div><?php
				} ?>
			</div>
		</div>
	</div><?php
pax_close_block( $container_args['container'] );