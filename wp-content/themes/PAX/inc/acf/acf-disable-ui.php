<?php
/**
 * ACF Menu Hide Based on User Role.
 */
function pax_show_admin( $show ) {
	return current_user_can( 'manage_options' );
}

add_filter( 'acf/settings/show_admin', 'pax_show_admin' );

/**
 * Hide menu items from the admin menu.
 * Disable UI for non admin users.
 */
//add_action('admin_menu', function () {
//    // List of users that don't have pages removed.
//    $admins = [
//        'bop-admin',
//        'emily',
//        'aivaras',
//        'developer',
//    ];
//
//    $current_user = wp_get_current_user();
//
//    if (!in_array($current_user->user_login, $admins)) {
//        remove_menu_page('edit.php?post_type=acf-field-group');
//    }
//}, PHP_INT_MAX);