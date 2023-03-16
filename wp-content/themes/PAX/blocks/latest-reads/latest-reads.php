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
$latest = get_field('latest');
$blog_posts = get_field('blog_posts');
$buttons = get_field('buttons_group');

// Create id attribute allowing for custom "anchor" value.
$id = 'latest-reads-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className".
$section_class_name = 'latest-reads';

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
if($latest == 1){ 
    $post = array(
        'post_type' => 'post',
        'post_status'   => 'publish',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    $wp_query = new WP_Query($post); 
    if ($wp_query->have_posts())
    { ?>
        <div class="latest-reads-main">
            <div class="latest-reads-container">
                <div class="latest-reads-inner"><?php 
                    while ($wp_query->have_posts())
                    {
                        $wp_query->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="latest-read-post">
                            <div class="latest-reads-item"><?php
                                if ( has_post_thumbnail() ) { ?>
                                    <div class="thumbnail_ava">
                                        <?php pax_post_thumbnail(); ?>
                                    </div><?php 
                                } ?>
                                <div class="case-study-block-bottom">
                                    <div class="news_content">       
                                        <h2 class="news_heading"><?php echo get_the_title(); ?></h2>
                                    </div>
                                    <div class="bottom-date-btn text-right">
                                       <span class="latest-reads-link">Read 
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9.59" height="11.371" viewBox="0 0 9.59 11.371"><path id="Path_55163" data-name="Path 55163" d="M6.98,32.948.918,27.263H5.985l3.7,3.7a2.806,2.806,0,0,1,0,3.969l-3.7,3.7H.918Z" transform="translate(-0.918 -27.263)" fill="#2a7de1"/>
                                            </svg>
                                       </span>
                                    </div>
                                </div>
                            </div>
                        </a><?php 
                    } wp_reset_postdata(); ?>
                </div>
                <div class="latest-reads-container-mobile">
                    <div class="swiper latest-reads-mobile-slider">
                        <div class="swiper-wrapper"><?php 
                            while ($wp_query->have_posts())
                            {
                                $wp_query->the_post(); ?>
                                <div class="swiper-slide latest-reads-inner">
                                    <a href="<?php the_permalink(); ?>" class="latest-read-post">
                                        <div class="latest-reads-item"><?php
                                            if ( has_post_thumbnail() ) { ?>
                                                <div class="thumbnail_ava">
                                                    <?php pax_post_thumbnail(); ?>
                                                </div><?php 
                                            } ?>
                                            <div class="case-study-block-bottom">
                                                <div class="news_content">       
                                                    <h2 class="news_heading"><?php echo get_the_title(); ?></h2>
                                                </div>
                                                <div class="bottom-date-btn text-right">
                                                   <span class="latest-reads-link">Read 
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="9.59" height="11.371" viewBox="0 0 9.59 11.371"><path id="Path_55163" data-name="Path 55163" d="M6.98,32.948.918,27.263H5.985l3.7,3.7a2.806,2.806,0,0,1,0,3.969l-3.7,3.7H.918Z" transform="translate(-0.918 -27.263)" fill="#2a7de1"/>
                                                        </svg>
                                                   </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div><?php 
                            } wp_reset_postdata(); ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>    
            </div><?php
            if(!empty($buttons)){
                pax_display_buttons($buttons);
            } ?>
        </div><?php
    } 
}
else{
    if(!empty($blog_posts)){ ?>
        <div class="latest-reads-main">
            <div class="latest-reads-container">
                <div class="latest-reads-inner"><?php
                    global $post; 
                    foreach ($blog_posts as $post) 
                    {
                        setup_postdata( $post ); ?>
                        <a href="<?php the_permalink(); ?>" class="latest-read-post">
                            <div class="latest-reads-item"><?php
                                if ( has_post_thumbnail() ) { ?>
                                    <div class="thumbnail_ava">
                                        <?php pax_post_thumbnail(); ?>
                                    </div><?php 
                                } ?>
                                <div class="case-study-block-bottom">
                                    <div class="news_content">       
                                        <h2 class="news_heading"><?php echo get_the_title(); ?></h2>
                                    </div>
                                    <div class="bottom-date-btn text-right">
                                       <span class="latest-reads-link">Read 
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9.59" height="11.371" viewBox="0 0 9.59 11.371"><path id="Path_55163" data-name="Path 55163" d="M6.98,32.948.918,27.263H5.985l3.7,3.7a2.806,2.806,0,0,1,0,3.969l-3.7,3.7H.918Z" transform="translate(-0.918 -27.263)" fill="#2a7de1"/>
                                            </svg>
                                       </span>
                                    </div>
                                </div>
                            </div>
                        </a><?php 
                    } wp_reset_postdata(); ?>
                </div>
                <div class="latest-reads-container-mobile">
                    <div class="swiper latest-reads-mobile-slider">
                        <div class="swiper-wrapper"><?php
                            global $post; 
                            foreach ($blog_posts as $post) 
                            {
                                setup_postdata( $post ); ?>
                                <div class="swiper-slide latest-reads-inner">
                                    <a href="<?php the_permalink(); ?>" class="latest-read-post">
                                        <div class="latest-reads-item"><?php
                                            if ( has_post_thumbnail() ) { ?>
                                                <div class="thumbnail_ava">
                                                    <?php pax_post_thumbnail(); ?>
                                                </div><?php 
                                            } ?>
                                            <div class="case-study-block-bottom">
                                                <div class="news_content">       
                                                    <h2 class="news_heading"><?php echo get_the_title(); ?></h2>
                                                </div>
                                                <div class="bottom-date-btn text-right">
                                                   <span class="latest-reads-link">Read 
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="9.59" height="11.371" viewBox="0 0 9.59 11.371"><path id="Path_55163" data-name="Path 55163" d="M6.98,32.948.918,27.263H5.985l3.7,3.7a2.806,2.806,0,0,1,0,3.969l-3.7,3.7H.918Z" transform="translate(-0.918 -27.263)" fill="#2a7de1"/>
                                                        </svg>
                                                   </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div><?php 
                            } wp_reset_postdata(); ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>          
            </div><?php
            if(!empty($buttons)){
                pax_display_buttons($buttons);
            } ?>
        </div><?php
    }
}
pax_close_block( $container_args['container'] ); ?>