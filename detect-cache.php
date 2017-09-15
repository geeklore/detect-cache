<?php
/*
Plugin Name: Detect Cache
Description: Checks HTTP headers, local files and Plugins for any caching.
Version: 0.1.0
Author: Shane Eckert
Text Domain: detect-cache
Domain Path: /languages
*/


/*
 * detect_cache_page
 *
 * Adds the Detect Cache plugin menu page to the sidebar and is used by add_action
 * Instead of passing a function as an argument, another file is passed. This is where
 * the main bulk of the code for the plugin resides. includes/detect-cache-admin.php
 *
 */

function detect_cache_page() {
    add_menu_page(
        __( 'Detect Cache', 'detect-cache' ),
        'Detect Cache',
        'manage_options',
        'detect-cache/includes/detect-cache-admin.php'
    );
}

add_action( 'admin_menu', 'detect_cache_page' );


/*
 * admin_style
 *
 * Adds some font styles to the plugin admin page.
 * The detect-cache-admin.css file must be placed in the root
 * of the current theme's folder.
 *
 */

// Update CSS within in Admin
function admin_style() {
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/detect-cache-admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');
