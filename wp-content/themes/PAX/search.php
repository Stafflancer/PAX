<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Bopper
 */

get_header();
$search_shortcode = get_field( 'search_shortcode', 'option' );
$promo_postcard = get_field( 'promo_postcard', 'option' );
$block = get_field( 'background_options', 'option' );

$tagline = $promo_postcard['tagline'];
$heading = $promo_postcard['heading'];
$content = $promo_postcard['content'];
$buttons = $promo_postcard['buttons_group'];
$image = $promo_postcard['image'];

preg_match_all('!\d+!', $search_shortcode, $matches);
$search_filter_id = implode(" ",$matches[0]); ?>
	<main id="primary" class="site-main">
		<div class="search-result-main">
			<header class="page-header">
				<h1 class="page-title">
					<label>SEARCH RESULTS</label>
					<span class="search-term"><?php echo get_search_query(); ?></span>
				</h1>
			</header><!-- .page-header --><?php
			if(!empty($tagline) || !empty($heading) || !empty($content) || !empty($buttons) || !empty($image)){ 
				wp_enqueue_style( 'search-promo-postcard-css', get_stylesheet_directory_uri() . '/blocks/promo-postcard/promo-postcard.css' );
				// Create id attribute allowing for custom "anchor" value.
				$id = 'promo-postcard' . $block['id'];

				if ( ! empty( $block['anchor'] ) ) {
					$id = $block['anchor'];
				}


				// Create class attribute allowing for custom "className".
				$section_class_name = 'promo-postcard';

				if ( ! empty( $block['className'] ) ) {
					$section_class_name .= ' ' . $block['className'];
				}



				// Start a <container> with possible block options.
				$container_args = [
					'container' => 'section', // Any HTML5 container: section, div, etc...
					'id'        => $id, // Container id.
					'class'     => $section_class_name, // Container class.
				];
				pax_global_background_display_options($block, $container_args);
				pax_promo_postcard($tagline, $heading, $content, $buttons, $image);
				pax_close_block( $container_args['container'] );
			} ?>
			<div class="main-con-div">
				<?php
				$paged        = ! empty( $_GET['sf_paged'] ) ? $_GET['sf_paged'] : 1;
				$globalsearch = new WP_Query( [
					'post_status'      => 'publish',
					'search_filter_id' => $search_filter_id,
					'paged'            => $paged,
				] );

				if ( $globalsearch->have_posts() ) {
					?>
					<div id="searchlist" class="globalsearch-list-block"><?php
						while ( $globalsearch->have_posts() ) {
							$globalsearch->the_post();
							$post_id = get_the_ID(); 
							if(get_post_type( get_the_ID() ) == 'faqs'){ 
								$global_post_type = 'FAQs';
							}
							else if(get_post_type( get_the_ID() ) == 'video-tutorials'){ 
								$global_post_type = 'Video Tutorials';
							}
							else if(get_post_type( get_the_ID() ) == 'documentation'){ 
								$global_post_type = 'Documents';
							}
							else if(get_post_type( get_the_ID() ) == 'post'){ 
								$global_post_type = 'Post';
							}
							else if(get_post_type( get_the_ID() ) == 'tribe_events'){ 
								$global_post_type = 'Events';
							}
							else if(get_post_type( get_the_ID() ) == 'press'){ 
								$global_post_type = 'Press';
							} 
							else if(get_post_type( get_the_ID() ) == 'careers'){ 
								$global_post_type = 'Careers';
							} 
							else if(get_post_type( get_the_ID() ) == 'news-post'){ 
								$global_post_type = 'News';
							} 
							else if(get_post_type( get_the_ID() ) == 'page'){ 
								$global_post_type = 'Page';
							} ?>
							<div class="globalsearch-list-items">
								<a href="<?php the_permalink( $post_id ); ?>">
									<div class="globalsearch-block-bottom">
										<div class="globalsearch_content">
											<label><?php echo $global_post_type; ?></label>
											<h2 class="globalsearch_heading"><?php echo get_the_title( $post_id ); ?></h2>
											<div class="globalsearch-para-block">
												<?php the_excerpt(); ?>
											</div>
										</div>
										<div class="blog-button-bottom">
											<div class="bottom-date-btn text-right">
												<span class="common-btn sbtn-view">
													Read
													<svg xmlns="http://www.w3.org/2000/svg" width="9.59" height="11.371" viewBox="0 0 9.59 11.371"><path id="Path_55163" data-name="Path 55163" d="M6.98,32.948.918,27.263H5.985l3.7,3.7a2.806,2.806,0,0,1,0,3.969l-3.7,3.7H.918Z" transform="translate(-0.918 -27.263)" fill="#2a7de1"></path>
							                        </svg>
												</span>
											</div>
										</div>
									</div>
								</a>
							</div>
						<?php } ?>
					<?php if ( $globalsearch->max_num_pages > 1 ) { ?>
						<div class="pagination-set">
							<div class="pagination-bottom d-flex justify-content-center pagination">
								<?php
								echo paginate_links( [
									'prev_text' => "",
									'next_text' => "",
									'base'      => site_url() . '%_%',
									'format'    => "?paged=%#%",
									'total'     => $globalsearch->max_num_pages,
									'current'   => $paged,
									'mid_size'  => 1,
									'end_size'  => 0,
								] );
								?>
							</div>
						</div>
					<?php } ?>
					<?php wp_reset_postdata(); ?>
					</div>
				<?php } else { ?>
					<div class="result-not-found">
						<h2><?php _e( 'Nothing Found', THEME_TEXT_DOMAIN ); ?>!</h2>
					</div>
				<?php } ?>
			</div>
		</div>
	</main><!-- #main -->

<?php
get_footer();