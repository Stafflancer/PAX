<?php
$term_obj_list = get_the_terms( get_the_ID(), 'faq-category' );
if(!empty($term_obj_list)){ 
    $terms_string = join(' | ', wp_list_pluck($term_obj_list, 'name'));
} ?>
<div class="collapsDiv faqs-pannel-tab faq-toggle">
    <button class="accordion faqs-panel-heading">
        <div class="faqs-content"><?php
            if(!empty($terms_string)){ ?>
                <label><?php echo $terms_string; ?></label><?php
            } ?>
            <h4><?php the_title(); ?></h4>
        </div>
    </button>
    <div class="panel faqs-panel-content" style="display: none;">
        <div class="pannel-in">
            <?php echo get_the_content(); ?>
        </div>
    </div>
 </div>