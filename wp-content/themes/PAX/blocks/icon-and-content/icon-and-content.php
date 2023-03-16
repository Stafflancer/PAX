<?php
/**
 * Icon + Content
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$icon = get_field('icon');
$section_header = get_field('section_header');
$content_heading = get_field('content_heading');
$content_description = get_field('content_description');
$content_icon = get_field('content_icon');

// Create id attribute allowing for custom "anchor" value.
$id = 'icon-and-content' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className".
$section_class_name = 'icon-and-content';

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
	<div class="icon-content-info">
		<div class="icon-content-info-inner"><?php
			if(!empty($icon) && !empty($icon['url'])){ ?>
				<div class="icon">
					<img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
				</div><?php
			}
			if(!empty($section_header)){
				pax_section_header($section_header);
			} ?>
		</div><?php
		if(!empty($content_heading) || !empty($content_description) || !empty($content_icon) && !empty($content_icon['url'])){ ?>
			<div class="content-heading-description"><?php
				if(!empty($content_icon) && !empty($content_icon['url'])){ ?>
					<div class="content_icon">
						<img src="<?php echo esc_url($content_icon['url']); ?>" alt="<?php echo esc_attr($content_icon['alt']); ?>">
					</div><?php
				}?>
				<div class="content-icon-right"><?php
					if(!empty($content_heading)){ ?>
						<h2><?php echo $content_heading; ?></h2><?php
					} 
					if(!empty($content_description)){ ?>
						<div class="description">
							<?php echo $content_description; ?>
						</div><?php
					} ?>
				</div>
			</div><?php
		} ?>
		<div class="content-heading-outer"><?php
			if(have_rows('content_left')){ ?>
				<div class="content-left"><?php
					while(have_rows('content_left')){
						the_row();
						$content_left_heading = get_sub_field('content_left_heading');
						$content_left_content = get_sub_field('content_left_content');
						$content_left_list_style = get_sub_field('content_left_list_style'); 
						$left_list = get_sub_field('left_list'); ?>
						<div class="content-item"><?php
							if(!empty($content_left_heading)){ ?>
								<h3><?php echo $content_left_heading; ?></h3><?php
							} 
							if(!empty($content_left_content)){ ?>
								<div class="content-description">
									<?php echo $content_left_content; ?>
								</div><?php
							} ?>
						</div><?php
						if(!empty($left_list)){ ?>
							<div class="content-list <?php echo 'list-style-'.$content_left_list_style; ?>"><?php
								foreach($left_list as $list){
									$list_item = $list['list_item'];
									if(!empty($list_item)){ ?>
										<h4><?php echo $list_item; ?></h4><?php
									}
								} ?>
							</div><?php
						}
					} ?>
				</div><?php
			} 
			if(have_rows('content_right')){ ?>
				<div class="content-right"><?php
					while(have_rows('content_right')){
						the_row();
						$content_right_heading = get_sub_field('content_right_heading');
						$content_right_content = get_sub_field('content_right_content');
						$content_right_list_style = get_sub_field('content_right_list_style');
						$right_list = get_sub_field('right_list');  ?>
						<div class="content-item"><?php
							if(!empty($content_right_heading)){ ?>
								<h3><?php echo $content_right_heading; ?></h3><?php
							} 
							if(!empty($content_right_content)){ ?>
								<div class="content-description">
									<?php echo $content_right_content; ?>
								</div><?php
							} ?>
						</div><?php
						if(!empty($right_list)){  ?>
							<div class="content-list <?php echo 'list-style-'.$content_right_list_style; ?>"><?php
								foreach($right_list as $list){ 
									$second_list_item = $list['second_list_item']; 
									if(!empty($second_list_item)){ ?>
										<h4><?php echo $second_list_item; ?></h4><?php
									}	
								} ?>
							</div><?php
						}
					} ?>
				</div><?php
			} ?>
		</div>
	</div><?php
pax_close_block( $container_args['container'] );