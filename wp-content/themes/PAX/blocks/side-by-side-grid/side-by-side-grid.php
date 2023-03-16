<?php
/**
 * Side by Side (Grid) Block Template.
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
$content = get_field('content');

if(!empty($image) && !empty($image['url']) || !empty($content)){
	// Create id attribute allowing for custom "anchor" value.
	$id = 'side-by-side-grid' . $block['id'];

	if ( ! empty( $block['anchor'] ) ) {
		$id = $block['anchor'];
	}


	// Create class attribute allowing for custom "className".
	$section_class_name = 'side-by-side-grid';

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
		<div class="side-by-side-grid-main <?php echo 'column-order '.$column_order; ?>">
			<div class="side-by-side-grid-outer"><?php
				if(!empty($image) && !empty($image['url'])){ ?>
					<div class="image">
						<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
					</div><?php
				} 
				if(have_rows('content')){ ?>
					<div class="side-by-side-grid-content"><?php
						while(have_rows('content')){
							the_row();
							$heading = get_sub_field('heading');
							$content = get_sub_field('content');
							$buttons = get_sub_field('buttons_group'); ?>
							<div class="grid-content-item"><?php
								if(!empty($heading)){ ?>
									<h2><?php echo $heading; ?></h2><?php
								} 
								if(!empty($content)){ ?>
									<div class="content">
										<?php echo $content; ?>
									</div><?php
								} 
								if(!empty($buttons)){
									pax_display_buttons($buttons);
								} ?>
							</div><?php
						} ?>
					</div><?php
				} ?>
			</div>
		</div><?php
	pax_close_block( $container_args['container'] );
}