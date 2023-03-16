<?php 
$video = get_field('video'); 
$optional_link = get_field('optional_link');
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
    <div class="video-item"><?php
        if(!empty($video)){?>
            <div class="video">
                <?php echo $iframe; ?>
            </div><?php
        } ?>
        <div class="video-text">
            <div class="video-text-inner">
                <h4><?php the_title(); ?></h4>
                <?php echo get_the_excerpt(); ?>
            </div><?php
            if(!empty($optional_link) && !empty($optional_link['url'])){ ?>
                <div class="video-optional-link">
                    <a href="<?php echo esc_url($optional_link['url']); ?>" target="<?php echo $optional_link['target']; ?>"><?php echo $optional_link['title']; ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="9.59" height="11.371" viewBox="0 0 9.59 11.371"><path id="Path_55163" data-name="Path 55163" d="M6.98,32.948.918,27.263H5.985l3.7,3.7a2.806,2.806,0,0,1,0,3.969l-3.7,3.7H.918Z" transform="translate(-0.918 -27.263)" fill="#2a7de1"></path>
                        </svg>
                    </a>
                </div><?php
            } ?>
        </div>
    </div>