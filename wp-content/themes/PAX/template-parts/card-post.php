<?php
/**
 * Template part for displaying reusable card in blocks and archives.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PAX
 */

?>
<div class="blog-list-items">
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="blog_img">
			<?php pax_post_thumbnail(); ?>
		</div>
	<?php } ?>
	<div class="blog-block-bottom">
		<div class="blog_content">
			<h2 class="blog_heading"><?php echo get_the_title(); ?></h2>
			<div class="post-card-content">
				<?php echo excerpt(40); ?>
			</div>
		</div>
		<div class="blog-link">
			<a href="<?php the_permalink(); ?>">Read
				<svg xmlns="http://www.w3.org/2000/svg" width="9.59" height="11.371" viewBox="0 0 9.59 11.371"><path id="Path_55163" data-name="Path 55163" d="M6.98,32.948.918,27.263H5.985l3.7,3.7a2.806,2.806,0,0,1,0,3.969l-3.7,3.7H.918Z" transform="translate(-0.918 -27.263)" fill="#2a7de1"></path>
	            </svg>
			</a>
		</div>
	</div>
</div>