<?php
/**
 * Slider - Upcoming Events
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$section_header = get_field('section_header');
$custom_list = get_field('custom_list');
$events = get_field('events');

// Create id attribute allowing for custom "anchor" value.
$id = 'slider-upcoming-events' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}


// Create class attribute allowing for custom "className".
$section_class_name = 'slider-upcoming-events';

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
	if(!empty($section_header)){
		pax_section_header($section_header);
	} 
	if($custom_list == 1 && !empty($events)){ ?>
		<div class="upcoming-events-outer">
			<div class="upcoming-events swiper upcoming-events-slider">
				<div class="swiper-wrapper"><?php
				 	foreach( $events as $post ){ 
				 		$events_meta = get_post_meta($post);
				 		if(!empty($events_meta['_EventVenueID'])){
					 	 	$venue_id = $events_meta['_EventVenueID'][0];
					 		$venu_meta = get_post_meta($venue_id);
							$venue_address = $venu_meta['_VenueAddress'][0];
					 	}
				 		$eventstartdate = $events_meta['_EventStartDate'][0];
				 		$eventenddate = $events_meta['_EventEndDate'][0];
				 		$newstartDate = date("F d - ", strtotime($eventstartdate));
				 		$newendDate = date("d, Y", strtotime($eventenddate));
				 		$title = get_the_title( $post );
				 		$permalink = get_permalink( $post );
				 		$featured_image = wp_get_attachment_url( get_post_thumbnail_id($post) );
				 		$categories = get_the_terms( $post, 'category' );
		                $category_name = array();
		                 if(!empty($categories)){
		                    foreach( $categories as $category ) {
		                        $category_name[] = $category->name;
		                    } 
		               	} ?>
						<div class="upcoming-events-item swiper-slide">
							<div class="upcoming-events-item-inner"><?php 
			                    if (!empty($featured_image)) { ?>
									<div class="upcoming-event-image">
			                            <img src="<?php echo $featured_image; ?>">
									</div><?php 
			                    } ?>
			                    <div class="upcoming-events-content">
			                    	<div class="upcoming-events-text">
				                    	<div class="event-type-tag">UPCOMING <span class="event-type">EVENT</span></div>
				                    	<div class="events-content"><?php
				                            if(!empty($categories)){ ?>
				                                 <label><?php echo implode(" | ",$category_name); ?></label><?php
				                            } ?>
				                            <h2 class="event-heading"><?php echo $title; ?></h2>
				                            <?php echo get_the_excerpt($post); ?>
				                        </div>
				                    </div>
			                        <div class="date-time-outer">
				                        <div class="date-time">
				                        	<span><?php echo $newstartDate.$newendDate; ?></span><?php if(!empty($venue_address)){ echo ' | '.$venue_address; } ?>
				                        </div>
				                        <div class="event-register-btn">
				                        	<a href="<?php echo $permalink; ?>" class="register-link">REGISTER TODAY</a>
				                        </div>
				                    </div>
			                    </div>
			                </div>
						</div><?php
					} ?>
				</div>
				<div class="swiper-button-next"></div>
	    		<div class="swiper-button-prev"></div>
			</div>
		</div><?php
	}
pax_close_block( $container_args['container'] );