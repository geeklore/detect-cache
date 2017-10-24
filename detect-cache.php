<?php
/**
* Plugin Name: Detect Cache
* Description: Checks HTTP headers, local files and Plugins for any caching.
* Version: 1.0
* Author: Shane Eckert
* Text Domain: detect-cache
* Domain Path: /languages/
* License: GPL-2.0+
* License URI: http://www.gnu.org/licenses/gpl-2.0.txt
* Detect Cache is free software: you can redistribute it and/or modify it under the terms of the 
* GNU General Public License as published by the Free Software Foundation, either version 2 of the 
* License, or any later version.
* 
* Detect Cache is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even 
* the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public 
* License for more details. You should have received a copy of the GNU General Public License along 
* with Detect Cache. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
*/

if ( ! defined( 'WPINC' ) ) {
  die;
}

define( 'DETECT_CACHE', '1.0.0' );

/*
 * Function sedc_cache_display_page Adds the Detect Cache plugin menu page to the 
 * sidebar and is used by add_action.
 */

function sedc_cache_display_page() {
  add_menu_page(
    __( 'Detect Cache', 'detect-cache' ),
    'Detect Cache',
    'manage_options',
    'detect-cache',
    $function ='sedc_cache_detection'
    );
}

/*
 * Action sedc_cache_display_page calls the function sedc_cache_detection.
 */

add_action( 'admin_menu', 'sedc_cache_display_page' );

/*
 * Function sedc_cache_detection
 * Plugin checks for caching in three ways.
 * 1. Plugin checks the site's (using site_url()) HTTP headers for caching directives, 
 * Load Balancers, proxies and proxy services like CloudFlare.
 * 2. Plugin also checks active plugins for any that have the word cache in them.
 * 3. Plugin checks the /wp-content/ directory for directories with the name cache in.
 */

function sedc_cache_detection() {
  printf( "<div class=wrap>" );
  _e( '<h1> Detect Cache </h1>', 'detect-cache' );
  _e( '<p> Detect Cache will automatically check the site\'s headers for caching and display the results below.</p>', 'detect-cache' );
  $url = site_url();
  _e( '<h2> Detecting cache in HTTP headers</h2>', 'detect-cache' );

/*
 * Setting this variable to 0, if set to 1 during the foreach loop
 * then there is no cache found in the header and a message is printed
 * indicating such.
 */
  $header_cache_found = '0';

/*
 * foreach loops through the array $header built by the get_headers() function
 * and tests for key words. 
 */
  $header = get_headers($url);
  foreach ($header as $key=>$value) {
    /**
     * Condition to check for the word cache in the header.
     */
    if ( stripos($value, "cache") !== false ) {
      printf( "<span class='cacheDetected'>" );
      _e( 'X-Cache directive', 'detect-cache' );
      printf( "<span class='cacheAlert'>" );
      _e( ' detected', 'detect-cache' );
      printf( "</span> " );
      _e( 'in header.', 'detect-cache' );
      printf( "</span><br>" );
      printf( "<span class='cacheFont'>" );
      printf(
      __( 'Line: %s <b>%s</b>', 'detect-cache'), $key,$value   
      );
      printf(" </span><br> ");
      $header_cache_found = '1';
    /**
     * Condition to check for the word CloudFlare in the header.
     */
    } elseif ( stripos($value, "cloudflare") !== false ) {
      printf( "<span class='cacheDetected'>" );
      _e( 'CloudFlare', 'detect-cache' );
      printf( "<span class='cacheAlert'>" );
      _e( ' detected', 'detect-cache' );
      printf( "</span> ");
      _e( 'in header.', 'detect-cache' );
      printf( "</span><br>");
      printf( "<span class='cacheFont'>" );
      printf(
      __( '<b>%s</b>', 'detect-cache' ), $value   
      );
      printf("</span><br>");
      $header_cache_found = '1';
    /**
     * Condition to check for the word proxy in the header.
     */
    } elseif ( stripos($value, "proxy") !== false ) {
      printf( "<span class='cacheDetected'>" );
      _e( 'Proxy', 'detect-cache' );
      printf( "<span class='cacheAlert'>" );
      _e( ' detected', 'detect-cache' );
      printf( "</span> ");
      _e( 'in header.', 'detect-cache' );
      printf( "</span><br>");
      printf( "<span class='cacheFont'>" );
      printf(
      __( '<b>%s</b>', 'detect-cache'), $value   
      );
      printf( "</span><br>" );
      $header_cache_found = '1';
    /**
     * Condition to check for the word varnish in the header.
     */
    } elseif (stripos($value, "varnish") !== false ) {
      printf( "<span class='cacheDetected'>" );
      _e( 'Varnish Reverse Proxy', 'detect-cache' );
      printf( "<span class='cacheAlert'>" );
      _e( ' detected', 'detect-cache' );
      printf( "</span> ");
      _e( 'in header.', 'detect-cache' );
      printf( "</span><br>");
      printf( "<span class='cacheFont'>" );
      printf(
      __( '<b>%s</b>', 'detect-cache'), $value   
      );
      printf("</span><br>");
      $header_cache_found = '1';
    /**
     * Condition to check for Cache-Control in the header.
     */
    } elseif ( stripos($value, "Cache-Control") !== false ) {
      printf( "<span class='cacheDetected'>" );
      _e( 'Cache-Control', 'detect-cache' );
      printf( "<span class='cacheAlert'>" );
      _e( ' detected', 'detect-cache' );
      printf("</span> ");
      _e( 'in header.', 'detect-cache' );
      printf( "</span><br>");
      printf( "<span class='cacheFont'>" );
      printf(
      __( '<b>%s</b>', 'detect-cache'), $value   
      );
      printf(" </span><br>" );
      $header_cache_found = '1';
    } 
  }

  /**
   * If no conditions are met then display the message
   * No Caching detected in headers.
   */
  if ($header_cache_found == '0'){
    _e( 'No Caching detected in headers', 'detect-cache' );
  }

  _e( '<h2> Detecting cache folders in the wp-content directory</h2>', 'detect-cache' );

  /**
   * Get the path, set the directory to include wp-content and put
   * the values of scandir into $cache_files.
   */
  $path = get_home_path();
  $targetdir = "wp-content";
  $dir = "$path$targetdir";
  $cache_files = scandir($dir);

  /**
   * filesystem_cache_found is set to 0 so we can display a not found message if unchanged.
   */
  $filesystem_cache_found = '0';
  foreach ($cache_files as $key=>$value) {
    if (stripos($value, "cache") !== false) {
      printf( "<span class='cacheDetected'>" );
      _e( ' Possible caching directory', 'detect-cache' );
      printf( "</span> <span class='cacheAlert'>" );
      _e( ' detected', 'detect-cache' );
      printf( "</span><br>");
      printf( "<span class='cacheFont'>");
      _e( ' Possible caching directory', 'detect-cache' );
      printf(
       __( 'Directory located: <b>%s%s/%s</b>', 'detect-cache'), $path, $targetdir, $value 
      );
      printf( "</span>");
      $filesystem_cache_found = '1';
    }
  }

  /**
   * filesystem_cache_found if still 0 means none was found.
   * Dusplay No Caching folders detected in the wp-content directory. 
   */
  if ( $filesystem_cache_found == '0' ) {
    printf("
    <ul class='checkmark'>
    <li class='tick'>
    ");
    _e( ' No Caching folders detected in the wp-content directory. ', 'detect-cache' );
    printf("
    </li>
    </ul>
    ");
  }

  _e( ' <h2> Detecting caching plugins </h2> ', 'detect-cache' );

  /**
   * wp_get_active_and_valid_plugins queries for all installed and active plugins
   * which is then stored into the all_active_plugins array.
   */
  $all_active_plugins = wp_get_active_and_valid_plugins();

  /**
   * plugin_cache_found set to 0 so we can display a not found message if unchanged.
   */
  $plugin_cache_found = '0';
    foreach ($all_active_plugins as $key=>$value) {
      if( (stripos($value, "cache") !== false) && (stripos($value, "detect-cache") == false)) {
        printf("<span class=cacheDetected>");
        _e( ' Caching or cache related plugin ', 'detect-cache' );
        printf("</span> <span class='cacheAlert'>");
        _e( ' detected ', 'detect-cache' );
        printf("</span><br>");
        printf(
        __( '<b>%s</b>', 'detect-cache'), $value 
        );
        $plugin_cache_found = '1';
     }
  }

  /**
   * plugin_cache_found set to so no caching plugins were found.
   * Display No caching plugins were detected.
   */
  if($plugin_cache_found == '0') {
    printf("
      <ul class='checkmark'>
      <li class='tick'>
    ");
      _e( ' No caching plugins were detected. ', 'detect-cache' );
    printf("
      </li>
      </ul>
    ");
  }
  printf("</div>");
/**
 * End of the sedc_cache_detection function.
 */
}
?>