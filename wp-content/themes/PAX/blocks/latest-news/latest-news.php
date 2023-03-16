<?php
/**
 * Latest News Block Template.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$section_header = get_field('section_header');
$latest = get_field('latest');
$news = get_field('news');
$buttons = get_field('buttons_group');

// Create id attribute allowing for custom "anchor" value.
$id = 'latest-news-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className".
$section_class_name = 'latest-news';

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
if($news && $latest == 1)
{ ?>
    <div class="latest-news-main">
        <div class="latest-reads-container">
        	<div class="latest-reads-inner"><?php
            	global $post; 
                foreach ($news as $post) 
                {
                    setup_postdata( $post ); 
                    get_template_part( 'template-parts/card-news', 'page' );
                } wp_reset_postdata(); ?>
                </div><?php
                if(!empty($buttons)){
                    pax_display_buttons($buttons);
                } ?>
            </div>            
        </div>
    </div><?php
}
pax_close_block( $container_args['container'] ); ?>