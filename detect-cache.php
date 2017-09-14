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
 * my_custom_fonts
 *
 * Adds some font styles to the plugin admin page.
 *
 */

function my_custom_fonts() {
  echo '<style>
    body, td, textarea, input, select {
      font-family: "Lucida Grande";
      font-size: 13px;
    } 
  </style>';
}

add_action('admin_head', 'my_custom_fonts');
