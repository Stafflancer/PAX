<?php
get_header();

$post_id = is_home() ? get_option( 'page_for_posts' ) : get_the_ID();
?>
	<main id="main" class="site-main site-content template-blog template-page-for-posts home-php post-<?php echo esc_attr( $post_id ); ?>" role="main">
		<div class="entry-content">
			<?php
			$post    = get_post( $post_id );
			$content = apply_filters( 'the_content', $post->post_content );

			echo $content;
			?>
		</div>
	</main><!-- #main -->
<?php
get_footer();