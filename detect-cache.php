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
* Detect Cache is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.

* Detect Cache is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
* You should have received a copy of the GNU General Public License along with Detect Cache. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
*/

if ( ! defined( 'WPINC' ) ) {
  die;
}

define( 'detect-cache', '1.0.0' );


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
        'detect-cache',
        $function ='buildCachePage'
    );
}

add_action( 'admin_menu', 'detect_cache_page' );


/*
 * Plugin checks for caching in three ways.
 * 1. Plugin checks the site's (using site_url()) HTTP headers for caching directives, 
 * Load Balancers, proxies and proxy services like CloudFlare.
 * 2. Plugin also checks active plugins for any that have the word cache in them.
 * 3. Plugin checks the /wp-content/ directory for directories with the name cache in.
 *
 * TODO
 * 1. Plugin cache - get just the name, not the path to php file.
 * 2. I18n
 * 3. MU plugins
 *
 */
function buildCachePage(){
printf("<div class=wrap>");
  _e( '<h1> Detect Cache </h1>', 'detect-cache' );

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
// Is there X-Cache?
    if (stripos($value, "cache") !== false) {
      printf("<span class='cacheDetected'>");
      _e( 'X-Cache directive', 'detect-cache' );
      printf("<span class='cacheAlert'>");
      _e( ' detected', 'detect-cache' );
      printf("</span> ");
      _e( 'in header.', 'detect-cache' );
      printf("</span><br>");
      printf("<span class='cacheFont'>");
      printf(
       __( 'Line: %s <b>%s</b>', 'detect-cache'), $key,$value   
      );
      printf("</span><br>");
      $header_cache_found = '1';
// Is CloudFlare invoved?
    }elseif (stripos($value, "cloudflare") !== false) {
      printf("<span class='cacheDetected'>");
      _e( 'CloudFlare', 'detect-cache' );
      printf("<span class='cacheAlert'>");
      _e( ' detected', 'detect-cache' );
      printf("</span> ");
      _e( 'in header.', 'detect-cache' );
      printf("</span><br>");
      printf("<span class='cacheFont'>");
      printf(
       __( '<b>%s</b>', 'detect-cache'), $value   
      );
      printf("</span><br>");
        $header_cache_found = '1';
// Is there a Proxy involved?
    }elseif (stripos($value, "proxy") !== false) {
      printf("<span class='cacheDetected'>");
      _e( 'Proxy', 'detect-cache' );
      printf("<span class='cacheAlert'>");
      _e( ' detected', 'detect-cache' );
      printf("</span> ");
      _e( 'in header.', 'detect-cache' );
      printf("</span><br>");
      printf("<span class='cacheFont'>");
      printf(
       __( '<b>%s</b>', 'detect-cache'), $value   
      );
      printf("</span><br>");
        $header_cache_found = '1';
// Is there a Varnish server involved?
    }elseif (stripos($value, "varnish") !== false) {
      printf("<span class='cacheDetected'>");
      _e( 'Varnish Reverse Proxy', 'detect-cache' );
      printf("<span class='cacheAlert'>");
      _e( ' detected', 'detect-cache' );
      printf("</span> ");
      _e( 'in header.', 'detect-cache' );
      printf("</span><br>");
      printf("<span class='cacheFont'>");
      printf(
       __( '<b>%s</b>', 'detect-cache'), $value   
      );
      printf("</span><br>");
        $header_cache_found = '1';
// Is there actualy Cache-Control set? - would be nice to check for the time and print.
    }elseif (stripos($value, "Cache-Control") !== false) {
      printf("<span class='cacheDetected'>");
      _e( 'Cache-Control', 'detect-cache' );
      printf("<span class='cacheAlert'>");
      _e( ' detected', 'detect-cache' );
      printf("</span> ");
      _e( 'in header.', 'detect-cache' );
      printf("</span><br>");
      printf("<span class='cacheFont'>");
      printf(
       __( '<b>%s</b>', 'detect-cache'), $value   
      );
      printf("</span><br>");
        $header_cache_found = '1';
  } 
}


// Did we find any headers with "cache" in the name? If not, say so.
if ($header_cache_found == '0'){
    _e( 'No Caching detected in headers', 'detect-cache' );
}

    _e( '<h2> Detecting cache folders in the wp-content directory</h2>', 'detect-cache' );

// Get the path, set the directory to include wp-content and put
// the values of scandir into $cache_files
$path = get_home_path();
$targetdir = "wp-content";
$dir = "$path$targetdir";
$cache_files = scandir($dir);

// filesystem_cache_found is set to 0 so we can display a not found message if set to 0
$filesystem_cache_found = '0';
foreach ($cache_files as $key=>$value) {
    if (stripos($value, "cache") !== false) {
      printf("<span class='cacheDetected'>");
      _e( ' Possible caching directory', 'detect-cache' );
      printf("</span> <span class='cacheAlert'>");
      _e( ' detected', 'detect-cache' );
      printf("</span><br>");
      printf("<span class='cacheFont'>");
      _e( ' Possible caching directory', 'detect-cache' );
      printf(
       __( 'Directory located: <b>%s%s/%s</b>', 'detect-cache'), $path, $targetdir, $value 
      );
      printf("</span>");
      $filesystem_cache_found = '1';
    }
}
// Did we find any folders with "cache" in the name? If not, say so.
if ($filesystem_cache_found == '0'){
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

// wp_get_active_and_valid_plugins gets the active plugins, save to an empty array
$all_active_plugins = wp_get_active_and_valid_plugins();

/// plugin_cache_found set to 0 so we can display a not found message if 0
$plugin_cache_found = '0';
foreach ($all_active_plugins as $key=>$value) {
    if( (stripos($value, "cache") !== false) && (stripos($value, "detect-cache") == false)) {
      printf("<span class=cacheDetected>");
      _e( ' Caching or cache related plugin ', 'detect-cache' );
      printf("</span> <span class='cacheAlert'>");
      _e( ' detected ', 'detect-cache' );
      printf("</span><br>");
      //
      // Would like to show just the name instead of the path to php file
      //
      printf(
       __( '<b>%s</b>', 'detect-cache'), $value 
      );
      $plugin_cache_found = '1';
    }
}


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
}
?>