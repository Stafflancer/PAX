<?php
/**
 * Search & Filter Pro
 *
 * Sample Results Template
 *
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 *
 * Note: these templates are not full page templates, rather
 * just an encapsulation of the results loop which should
 * be inserted in to other pages by using a shortcode - think
 * of it as a template part
 *
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs
 * and using template tags -
 *
 * http://codex.wordpress.org/Template_Tags
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
$post_slug = $post->post_name;
$paged = ! empty( $_GET['sf_paged'] ) ? $_GET['sf_paged'] : 1;
if ($query->have_posts()) { ?>
	<div class="filter-list-block">
		<div class="latest-post-main <?php echo 'wrap-'.$post_slug; ?>" id="result_list"><?php
			while ($query->have_posts()) {
				$query->the_post(); 
				if(get_post_type( get_the_ID() ) == 'faqs'){ 
					get_template_part( 'template-parts/card-faqs', 'page' );
				}
				if(get_post_type( get_the_ID() ) == 'video-tutorials'){ 
					get_template_part( 'template-parts/card-video-tutorials', 'page' );
				}
				if(get_post_type( get_the_ID() ) == 'documentation'){ 
					get_template_part( 'template-parts/card-documentation', 'page' );
				}
				if(get_post_type( get_the_ID() ) == 'post'){ 
					get_template_part( 'template-parts/card-post', 'page' );
				}
				if(get_post_type( get_the_ID() ) == 'tribe_events'){ 
					get_template_part( 'template-parts/card-events', 'page' );
				}
				if(get_post_type( get_the_ID() ) == 'press'){ 
					get_template_part( 'template-parts/card-press-releases', 'page' );
				}
			} ?>
		</div><?php
		if($query->max_num_pages > 1)
		{ ?>	
			<div class="pagination-set">
				<div class="pagination-bottom d-flex justify-content-center pagination"><?php
					echo paginate_links( [
						'prev_text' => "previous",
						'next_text' => "next",
						'base'      => site_url() . '%_%',
						'format'    => "?paged=%#%",
						'total'     => $query->max_num_pages,
						'current'   => $paged,
						'mid_size'  => 1,
						'end_size'  => 0,
					] ); ?>
				</div>
			</div><?php
		} ?>
		<?php wp_reset_postdata(); ?>
	</div><?php 
}
else { ?>
	<div class="nothing-found">
		<h2>Nothing Found!</h2>
	</div><?php
} ?>