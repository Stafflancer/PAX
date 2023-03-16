<?php
/**
 * Latest posts Block Template.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$section_header = get_field('section_header');
$team = get_field('team');

// Create id attribute allowing for custom "anchor" value.
$id = 'meet-the-team-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className".
$section_class_name = 'meet-the-team';

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
if($section_header){
    pax_section_header($section_header);
}
if($team)
{ ?>
    <div class="meet-the-team-main">
        <div class="meet-the-team-container">
        	<div class="meet-the-team-inner"><?php
            	global $post; 
                foreach ($team as $post) 
                {
                    setup_postdata( $post ); 
                    $member_position = get_field('member_position', get_the_ID()); ?>
                    <div class="meet-the-team-item"><?php
                        if ( has_post_thumbnail() ) { ?>
                            <div class="thumbnail_ava">
                                <?php pax_post_thumbnail(); ?>
                            </div><?php 
                        } ?>
                        <div class="case-study-block-bottom">
                            <div class="news_content">       
                                <h2 class="news_heading"><?php echo get_the_title(); ?></h2><?php
                                if(!empty($member_position)){ ?>
                                    <label><?php echo $member_position; ?></label><?php
                                } ?>
                            </div>
                        </div>
                    </div><?php 
                } wp_reset_postdata(); ?>
            </div>
        </div>
    </div><?php
}
pax_close_block( $container_args['container'] ); ?>