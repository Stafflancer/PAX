<?php
/**
 * Offices Repeater
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$section_header = get_field('section_header');

// Create id attribute allowing for custom "anchor" value.
$id = 'offices-repeater' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'offices-repeater';

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
	<div class="offices-repeater-inner"><?php
		if(!empty($section_header)){
			pax_section_header($section_header);
		} ?>
		<div class="offices-repeater-content"><?php
			if(have_rows('offices')){ ?>
				<div class="offices-row"><?php
					while(have_rows('offices')){
						the_row();
						$image = get_sub_field('image');
						$heading = get_sub_field('heading');
						$address = get_sub_field('address');
						$contacts = get_sub_field('contacts'); ?>
						<div class="offices-repeater-item"><?php
							if(!empty($image) && !empty($image['url'])){ ?>
								<div class="offices-repeater-image">
									<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
								</div><?php
							} ?>
							<div class="headquarters-info"><?php 
								if(!empty($heading)){ ?>
									<h3><?php echo $heading; ?></h3><?php
								} 
								if(!empty($address)){ ?>
									<div class="headquarters">
										<?php echo $address; ?>
									</div><?php
								} 
								if(!empty($contacts)){ ?>
									<div class="contacts"><?php
										foreach($contacts as $contact){
											$title = $contact['title'];
											$link = $contact['link']; ?>
											<h6><?php
												if(!empty($title)){ ?>
													<span><?php echo $title.':'; ?></span><?php
												}
												if(!empty($link) && !empty($link['url'])){ ?>
													<a href="<?php echo esc_url($link['url']); ?>"><?php echo $link['title']; ?></a><?php
												}?>
											</h6><?php
										} ?>
									</div><?php
								} ?>
							</div>
						</div><?php
					} ?>
				</div><?php
			} ?>
		</div>
	</div><?php
pax_close_block( $container_args['container'] );