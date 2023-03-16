<?php 
$listing_button = get_field('listing_button'); 
$upload_type = get_field('upload_type');
$image = get_field('image');
$video = get_field('video'); 
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

    // Create id attribute allowing for custom "anchor" value.
} ?> 

    <div class="event-item"><?php
        if($upload_type == 'video'){
            if(!empty($video)){?>
                <div class="video">
                    <?php echo $iframe; ?>
                </div><?php
            } 
        } 
        else{ 
            if(!empty($image) && !empty($image['url'])){ ?>
                <div class="event-image">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                </div><?php
            }
        } ?>
        <div class="event-item-text">
            <div class="event-item-text-inner">
                <h4><?php the_title(); ?></h4>
                <div class="events-content">
                     <?php echo get_the_excerpt(); ?>
                 </div>
            </div><?php
            if($listing_button == 1){ ?>
                <div class="event-button">
                    <a href="<?php echo get_the_permalink(); ?>" class="events-link">OPTIONAL BUTTON</a>
                </div><?php
            } ?>
        </div>
    </div>