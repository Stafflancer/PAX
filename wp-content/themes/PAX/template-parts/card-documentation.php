<?php
$term_obj_list = get_the_terms( get_the_ID(), 'series-type' );
if(!empty($term_obj_list)){ 
    $terms_string = join(' | ', wp_list_pluck($term_obj_list, 'name'));
} ?>
<div class="document">
    <div class="video-item"><?php
        if(!empty($terms_string)){ ?>
            <label><?php echo $terms_string; ?></label><?php
        } ?>
    	<h2><?php the_title(); ?></h2>
    	<a href="<?php echo get_the_permalink(); ?>">View
    		<svg xmlns="http://www.w3.org/2000/svg" width="9.59" height="11.371" viewBox="0 0 9.59 11.371"><path id="Path_55163" data-name="Path 55163" d="M6.98,32.948.918,27.263H5.985l3.7,3.7a2.806,2.806,0,0,1,0,3.969l-3.7,3.7H.918Z" transform="translate(-0.918 -27.263)" fill="#2a7de1"></path>
            </svg>
        </a>
    </div>
</div>