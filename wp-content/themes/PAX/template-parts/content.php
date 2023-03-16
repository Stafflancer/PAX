<?php
/**
 * Template part for displaying posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PAX
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-container' ); ?>>
	<div class="single-post-text">
		<header class="entry-header"><?php
			if ( 'post' === get_post_type() ) { ?>
				<div class="reading"><?php echo do_shortcode('[rt_reading_time label="Reading Time:" postfix="minutes" postfix_singular="minute"]'); ?></div><?php
			}
			if ( 'documentation' === get_post_type() ) { ?>
				<div class="breadcrumb">
					<?php pax_display_breadcrumbs(); ?>
				</div><?php
			}
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif; ?>
		</header><!-- .entry-header -->

		<?php pax_post_thumbnail(); ?>
	</div>
	<div class="post-content">
		<?php get_template_part( 'template-parts/content', 'page' ); ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->