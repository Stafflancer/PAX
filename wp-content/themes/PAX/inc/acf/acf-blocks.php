<?php
add_filter( 'block_categories_all', 'filter_block_categories_when_post_provided', 1, 2 );
/**
 * Register custom block categories.
 * Filters the default array of categories for block types.
 *
 * @param $block_categories
 * @param $editor_context
 *
 * @return mixed
 */
function filter_block_categories_when_post_provided( $block_categories, $editor_context ) {
	if ( ! empty( $editor_context->post ) ) {
		array_push( $block_categories, array(
				'slug'  => 'acf',
				'title' => __( 'ACF Blocks', THEME_TEXT_DOMAIN ),
				'icon'  => null,
			) );
	}

	return $block_categories;
}

add_action( 'init', 'template_register_acf_blocks', 5 );
function template_register_acf_blocks() {
	$blocks_path = get_template_directory() . '/blocks';

	if ( file_exists( $blocks_path ) ) {
		$block_dirs  = array_filter( glob( $blocks_path . '/*' ), 'is_dir' );

		foreach ( $block_dirs as $block_dir ) {
			register_block_type( $block_dir );
		}
	}
}


/**
 * A callback function to output the block's HTML.
 *
 * @param array        $block      The block settings and attributes.
 * @param string       $content    The block inner HTML (empty).
 * @param bool         $is_preview True during AJAX preview.
 * @param (int|string) $post_id    The post ID this block is saved to.
 *
 * @return void
 */
function template_acf_block_render_callback( $block, $content = '', $is_preview = false, $post_id = 0 ) {
	// Convert name ("acf/hero-block") into path friendly slug ("hero-block").
	$slug = str_replace( 'acf/', '', $block['name'] );

	// Include a template part from within the "template-parts/block" folder.
	if ( file_exists( get_theme_file_path( "/template-parts/blocks/$slug/$slug.php" ) ) ) {
		include( get_theme_file_path( "/template-parts/blocks/$slug/$slug.php" ) );
	}
}