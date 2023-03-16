<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some functionality here could be replaced by core features.
 *
 * @package PAX
 */

/**
 * Returns true if a blog has more than 1 category, else false.
 *
 * @return bool Whether the blog has more than one category.
 * @author Bop Design
 *
 */
function pax_categorized_blog() {
	$category_count = get_transient( 'pax_categories' );

	if ( false === $category_count ) {
		$category_count_query = get_categories( [ 'fields' => 'count' ] );

		$category_count = isset( $category_count_query[0] ) ? (int) $category_count_query[0] : 0;

		set_transient( 'pax_categories', $category_count );
	}

	return $category_count > 1;
}

/**
 * Shortcode to display copyright year.
 *
 * @param array $atts Optional attributes.
 *                    $starting_year Optional. Define starting year to show starting year and current year e.g. 2010 -
 *                    2022.
 *                    $separator Optional. Separator between starting year and current year.
 *
 * @return string Copyright year text.
 */
function pax_copyright_year( $atts ) {
	// Setup defaults.
	$args = shortcode_atts( [
		'starting_year' => '',
		'separator'     => '-',
	], $atts );

	$current_year = gmdate( 'Y' );

	// Return current year if starting year is empty.
	if ( ! $args['starting_year'] ) {
		return $current_year;
	}

	return esc_html( $args['starting_year'] . $args['separator'] . $current_year );
}

add_shortcode( 'pax_copyright_year', 'pax_copyright_year' );