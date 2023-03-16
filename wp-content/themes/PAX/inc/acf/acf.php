<?php
/**
 * Custom ACF functions.
 *
 * A place to custom functionality related to Advanced Custom Fields.
 *
 * @package PAX
 */

// If ACF isn't activated, then bail.
if ( ! class_exists( 'ACF' ) ) {
	return false;
}

/**
 * ACF Menu Hide Based on User Role.
 */
require get_template_directory() . '/inc/acf/acf-disable-ui.php';

/**
 * Place ACF JSON in field-groups directory.
 */
require get_template_directory() . '/inc/acf/acf-json.php';

/**
 * Add ACF theme options support.
 */
require get_template_directory() . '/inc/acf/acf-options-page.php';

/**
 * Add ACF global functions.
 */
require get_template_directory() . '/inc/acf/acf-global-functions.php';

/**
 * Extend WordPress search to include custom fields.
 */
require get_template_directory() . '/inc/acf/acf-search.php';

/**
 * Preview with custom fields.
 */
require get_template_directory() . '/inc/acf/acf-preview.php';

/**
 * Registers a custom block type in the Gutenberg editor.
 */
require get_template_directory() . '/inc/acf/acf-blocks.php';

/**
 * Load functions used to output ACF Blocks.
 */
require get_template_directory() . '/inc/acf/acf-block-functions.php';