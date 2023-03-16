<?php
/**
 * Stats
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

if(have_rows('stats'))
{
	$section_header = get_field('section_header'); 
	
	// Create id attribute allowing for custom "anchor" value.
	$id = 'stats' . $block['id'];

	if ( ! empty( $block['anchor'] ) ) {
		$id = $block['anchor'];
	}


	// Create class attribute allowing for custom "className".
	$section_class_name = 'stats';

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
		<div class="stats">
			 <div class="stats-main"><?php
			 	if(!empty($section_header)){
					pax_section_header($section_header);
				}  ?>
                <div class="stats-row" id="stats_id"><?php
                	$counter = 1;
                    while(have_rows('stats'))
                    { 
                        the_row(); 
                        $prefix = get_sub_field('prefix');
                        $stat = get_sub_field('stat');
                        $suffix = get_sub_field('suffix');
                        $stats_heading = get_sub_field('heading'); ?>
                        <div class="stats-item">
                            <div class="prefix">
                                <h3><?php echo esc_html( $prefix ); ?><span id="odometer<?php echo $counter; ?>" class="odometernew" data-value="<?php echo esc_html( $stat ); ?>"><?php echo esc_html( $stat ); ?></span><?php echo esc_html( $suffix ); ?></h3><?php 
                                if (!empty($stats_heading)) 
                                { ?>
                                    <h6><?php echo $stats_heading; ?></h6><?php
                                } ?>
                            </div>
                         </div><?php
                         $counter++;
                    } ?>
                </div>
            </div>
		</div><?php
	pax_close_block( $container_args['container'] );
}