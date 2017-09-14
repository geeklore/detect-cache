<?php
/*
Plugin Name: Detect Cache
Plugin URI: https://wordpress.org/plugins/shaneeckert/
Description: Checks HTTP headers, local files and Plugins for any caching.
Version: 0.1.0
Author: Shane Eckert
Author URI: http://shane.blog
Text Domain: detect-cache
Domain Path: /languages
*/




function detect_cache_page() {
    add_menu_page(
        __( 'Detect Cache', 'textdomain' ),
        'Detect Cache',
        'manage_options',
        'detect-cache/includes/detect-cache-admin.php'
    );
}
add_action( 'admin_menu', 'detect_cache_page' );



