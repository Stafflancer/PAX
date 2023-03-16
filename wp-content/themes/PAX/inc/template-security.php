<?php
/**
 * Security functions.
 *
 * Enable or disable certain functionality to harden WordPress.
 *
 * @package PAX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove generator meta tags.
 *
 * @author Bop Design
 * @see    https://developer.wordpress.org/reference/functions/the_generator/
 */
add_filter( 'the_generator', '__return_false' );

/**
 * Disable XML RPC.
 *
 * @author Bop Design
 * @see    https://developer.wordpress.org/reference/hooks/xmlrpc_enabled/
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Change REST-API header from "null" to "*".
 *
 * @author Bop Design
 * @see    https://w3c.github.io/webappsec-cors-for-developers/#avoid-returning-access-control-allow-origin-null
 */
function pax_cors_control() {
	header( 'Access-Control-Allow-Origin: *' );
}

add_action( 'rest_api_init', 'pax_cors_control' );

/**
 * Disable use X-Pingback.
 *
 * @param $headers
 *
 * @return mixed
 */
function disable_x_pingback( $headers ) {
	unset( $headers['X-Pingback'] );

	return $headers;
}

add_filter( 'wp_headers', 'disable_x_pingback' );

/**
 * Login page custom messages.
 *
 * @return string
 */
function pax_add_login_message() {
	return '<p class="message"><strong>Tip:</strong> Use a unique and complex password to keep your login secure.</p>';
}

add_filter( 'login_message', 'pax_add_login_message' );

/**
 * Show less info to users on failed login for security.
 * On a failed login attempt, WordPress shows errors that tell users whether their username was incorrect or
 * the password. These login hints can be used by someone for malicious attempts.
 * (Will not let a valid username be known.)
 *
 * @return string
 */
function pax_no_wordpress_errors() {
	return '<strong>ERROR</strong>: Something is wrong!';
}

add_filter( 'login_errors', 'pax_no_wordpress_errors' );