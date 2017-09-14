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


add_action( 'admin_menu', 'detect_cache' );

function detect_cache() {
	add_menu_page( 'Detect Cache', 'Detect Cache', 'manage_options', 'detect-cache', 'my_plugin_options' );
}

function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
}

$url = site_url();
//print_r(get_headers($url));


$result = array();
$header = get_headers($url);
foreach ($header as $key=>$value) {
	// if ($value contains 'cache') {
    if (is_array($value)) {
        $value = end($value);
    }
    $result[$key] = $value;
    echo "<div align=center>";
    echo "$key: $value";
    echo "<br>";
    echo "</div>";
}


