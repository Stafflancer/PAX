<?php
/**
 * Action hooks and filters.
 *
 * A place to put hooks and filters that aren't necessarily template tags.
 *
 * @package PAX
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array Body classes.
 * @author PAX
 *
 */
function pax_body_classes( $classes ) {
	// Allows for incorrect snake case like is_IE to be used without throwing errors.
	global $is_IE, $is_edge, $is_safari;

	// If it's IE, add a class.
	if ( $is_IE ) {
		$classes[] = 'ie';
	}

	// If it's Edge, add a class.
	if ( $is_edge ) {
		$classes[] = 'edge';
	}

	// If it's Safari, add a class.
	if ( $is_safari ) {
		$classes[] = 'safari';
	}

	// Are we on mobile?
	if ( wp_is_mobile() ) {
		$classes[] = 'mobile';
	}

	// Give all pages a unique class.
	if ( is_page() ) {
		$classes[] = 'page-' . basename( get_permalink() );
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds "no-js" class. If JS is enabled, this will be replaced (by javascript) to "js".
	$classes[] = 'no-js';

	return $classes;
}

add_filter( 'body_class', 'pax_body_classes' );

/**
 * Flush out the transients used in pax_categorized_blog.
 *
 * @return bool Whether transients were deleted.
 */
function pax_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return false;
	}

	return delete_transient( 'pax_categories' );
}

add_action( 'delete_category', 'pax_category_transient_flusher' );
add_action( 'save_post', 'pax_category_transient_flusher' );

/**
 * Customize "Read More" string on <!-- more --> with the_content();
 *
 * @return string Read more link.
 */
function pax_content_more_link() {
	return ' <a class="more-link" href="' . get_permalink() . '">' . esc_html__( 'Read More', THEME_TEXT_DOMAIN ) . '...</a>';
}

add_filter( 'the_content_more_link', 'pax_content_more_link' );

/**
 * Shorten Excerpt.
 *
 * @param $length
 *
 * @return int
 */

function excerpt($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
 }

/**
 * Customize the [...] on the_excerpt();
 *
 * @param string $more The current $more string.
 *
 * @return string Read more link.
 */
function pax_excerpt_more( $more ) {
	return '...';
}

add_filter( 'excerpt_more', 'pax_excerpt_more' );

/**
 * Filters WYSIWYG content with the_content filter.
 *
 * @param string $content content dump from WYSIWYG.
 *
 * @return string|bool Content string if content exists, else empty.
 */
function pax_get_the_content( $content ) {
	return ! empty( $content ) ? $content : false;
}

add_filter( 'the_content', 'pax_get_the_content', 20 );

/**
 * Enable custom mime types.
 *
 * @param array $mimes Current allowed mime types.
 *
 * @return array Mime types.
 * @author PAX
 */
function pax_custom_mime_types( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'pax_custom_mime_types' );

/**
 * Add SVG definitions to footer.
 *
 * @author PAX
 */
function pax_include_svg_icons() {
	// Add the path to your SVG directory inside your theme.
	$svg_path = '/assets/images/icons/';

	// Define SVG sprite file.
	$svg_icons = get_template_directory() . $svg_path . 'sprite.svg';

	// Check the SVG file exists, echo it.
	if ( file_exists( $svg_icons ) ) {
		echo '<div class="svg-sprite-wrapper">';
		// Load and return the contents of the file
		echo file_get_contents( $svg_icons );
		echo '</div>';
	}
}

add_action( 'wp_footer', 'pax_include_svg_icons', 9999 );

/**
 * Adds OG tags to the head for better social sharing.
 *
 * @return string An empty string if Yoast is not found, otherwise a block of meta tag HTML.
 * @author Corey Collins
 */
function pax_add_og_tags() {
	// Bail if Yoast is installed, since it will handle things.
	if ( class_exists( 'WPSEO_Options' ) ) {
		return '';
	}

	// Set a post global on single posts. This avoids grabbing content from the first post on an archive page.
	if ( is_singular() ) {
		global $post;
	}

	// Get the post content.
	$post_content = ! empty( $post ) ? $post->post_content : '';

	// Strip all tags from the post content we just grabbed.
	$default_content = ( $post_content ) ? wp_strip_all_tags( strip_shortcodes( $post_content ) ) : $post_content;

	// Set our default title.
	$default_title = get_bloginfo( 'name' );

	// Set our default URL.
	$default_url = get_permalink();

	// Set our base description.
	$default_base_description = ( get_bloginfo( 'description' ) ) ? get_bloginfo( 'description' ) : esc_html__( 'Visit our website to learn more.', THEME_TEXT_DOMAIN );

	// Set the card type.
	$default_type = 'article';

	// Get our custom logo URL. We'll use this on archives and when no featured image is found.
	$logo_id    = get_theme_mod( 'custom_logo' );
	$logo_image = ( $logo_id ) ? wp_get_attachment_image_src( $logo_id, 'full' ) : '';
	$logo_url   = ( $logo_id ) ? $logo_image[0] : '';

	// Set our final defaults.
	$card_title            = $default_title;
	$card_description      = $default_base_description;
	$card_long_description = $default_base_description;
	$card_url              = $default_url;
	$card_image            = $logo_url;
	$card_type             = $default_type;

	// Let's start overriding!
	// All singles.
	if ( is_singular() ) {
		if ( has_post_thumbnail() ) {
			$card_image = get_the_post_thumbnail_url();
		}
	}

	// Single posts/pages that aren't the front page.
	if ( is_singular() && ! is_front_page() ) {
		$card_title            = get_the_title() . ' - ' . $default_title;
		$card_description      = ( $default_content ) ? wp_trim_words( $default_content, 53, '...' ) : $default_base_description;
		$card_long_description = ( $default_content ) ? wp_trim_words( $default_content, 140, '...' ) : $default_base_description;
	}

	// Categories, Tags, and Custom Taxonomies.
	if ( is_category() || is_tag() || is_tax() ) {
		$term_name      = single_term_title( '', false );
		$card_title     = $term_name . ' - ' . $default_title;
		$specify        = ( is_category() ) ? esc_html__( 'categorized in', THEME_TEXT_DOMAIN ) : esc_html__( 'tagged with', THEME_TEXT_DOMAIN );
		$queried_object = get_queried_object();
		$card_url       = get_term_link( $queried_object );
		$card_type      = 'website';

		// Translators: get the term name.
		$card_long_description = sprintf( esc_html__( 'Posts %1$s %2$s.', THEME_TEXT_DOMAIN ), $specify, $term_name );
		$card_description      = $card_long_description;
	}

	// Search results.
	if ( is_search() ) {
		$search_term = get_search_query();
		$card_title  = $search_term . ' - ' . $default_title;
		$card_url    = get_search_link( $search_term );
		$card_type   = 'website';

		// Translators: get the search term.
		$card_long_description = sprintf( esc_html__( 'Search results for %s.', THEME_TEXT_DOMAIN ), $search_term );
		$card_description      = $card_long_description;
	}

	if ( is_home() ) {
		$posts_page = get_option( 'page_for_posts' );
		$card_title = get_the_title( $posts_page ) . ' - ' . $default_title;
		$card_url   = get_permalink( $posts_page );
		$card_type  = 'website';
	}

	// Front page.
	if ( is_front_page() ) {
		$front_page = get_option( 'page_on_front' );
		$card_title = ( $front_page ) ? get_the_title( $front_page ) . ' - ' . $default_title : $default_title;
		$card_url   = get_home_url();
		$card_type  = 'website';
	}

	// Post type archives.
	if ( is_post_type_archive() ) {
		$post_type_name = get_post_type();
		$card_title     = $post_type_name . ' - ' . $default_title;
		$card_url       = get_post_type_archive_link( $post_type_name );
		$card_type      = 'website';
	}

	// Media page.
	if ( is_attachment() ) {
		$attachment_id = get_the_ID();
		$card_image    = ( wp_attachment_is_image( $attachment_id ) ) ? wp_get_attachment_image_url( $attachment_id, 'full' ) : $card_image;
	}

	?>
	<meta property="og:title" content="<?php echo esc_attr( $card_title ); ?>"/>
	<meta property="og:description" content="<?php echo esc_attr( $card_description ); ?>"/>
	<meta property="og:url" content="<?php echo esc_url( $card_url ); ?>"/>
	<?php if ( $card_image ) : ?>
		<meta property="og:image" content="<?php echo esc_url( $card_image ); ?>"/>
	<?php endif; ?>
	<meta property="og:site_name" content="<?php echo esc_attr( $default_title ); ?>"/>
	<meta property="og:type" content="<?php echo esc_attr( $card_type ); ?>"/>
	<meta name="description" content="<?php echo esc_attr( $card_long_description ); ?>"/>
	<?php
}

add_action( 'wp_head', 'pax_add_og_tags' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function pax_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'pax_pingback_header' );

/**
 * Removes or Adjusts the prefix on category archive page titles.
 *
 * @param string $block_title The default $block_title of the page.
 *
 * @return string The updated $block_title.
 */
function pax_remove_archive_title_prefix( $block_title ) {
	// Get the single category title with no prefix.
	$single_cat_title = single_term_title( '', false );

	if ( is_category() || is_tag() || is_tax() ) {
		return esc_html( $single_cat_title );
	}

	return $block_title;
}

add_filter( 'get_the_archive_title', 'pax_remove_archive_title_prefix' );

/**
 * Disables wpautop to remove empty p tags in rendered Gutenberg blocks.
 */
function pax_disable_wpautop_for_gutenberg() {
	// If we have blocks in place, don't add wpautop.
	if ( has_filter( 'the_content', 'wpautop' ) && has_blocks() ) {
		remove_filter( 'the_content', 'wpautop' );
	}
}

add_filter( 'init', 'pax_disable_wpautop_for_gutenberg', 9 );

/**
 * Force Yoast panel to the bottom of edit screens.
 * Move Yoast settings panel to bottom of page.
 */
add_filter( 'wpseo_metabox_prio', function () {
	return 'low';
}, 100, 1 );

/**
 * Filters whether block styles should be loaded separately - only load styles for used blocks.
 *
 * Returning false loads all core block assets, regardless of whether they are rendered
 * in a page or not. Returning true loads core block assets only when they are rendered.
 *
 * $load_separate_assets
 *     (bool) Whether separate assets will be loaded.
 *     Default false (all block assets are loaded, even when not used).
 */
add_filter( 'should_load_separate_core_block_assets', '__return_true' );

/**
 * Prevent loading patterns from the WordPress.org pattern directory.
 */
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Show '(No title)' if post has no title.
 */
add_filter(
	'the_title',
	function( $title ) {
		if ( ! is_admin() && empty( $title ) ) {
			$title = __( '(No title)', THEME_TEXT_DOMAIN );
		}

		return $title;
	}
);

/**
 * Modify the path to the icons' directory.
 */
add_filter( 'acf_icon_path_suffix', function ( $path_suffix ) {
	return 'assets/images/acf-icons/';
} );

/**
 * Modify the path to the above prefix.
 */
add_filter( 'acf_icon_path', function ( $path_suffix ) {
	return get_template_directory();
} );

/**
 * Modify the URL to the icons' directory to display on the page.
 */
add_filter( 'acf_icon_url', function ( $path_suffix ) {
	return get_stylesheet_directory_uri();
} );


function event_date_year_on_save( $post_id ) {

  $post_type = 'press'; //custom post type for events

  //Check if we are saving correct post type
  if( get_post_type( $post_id ) != $post_type)
    return;

  //Check it's not an auto save routine
  if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return;
  
  // get the event date of the post. Note this is in YYYYMMDD format
  $event_date = get_the_date('Y');
 
  // update the event year value 
  update_field( 'updated_date', $event_date, $post_id );

}
add_action('save_post', 'event_date_year_on_save');