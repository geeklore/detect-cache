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
  echo "<style>

    body, td, textarea, input, select {
      font-family: 'verdana';
      font-size: 13px;
      color: #96588a;
    } 
	.cacheDetected {
    color: #3c3c3c;
    font-family: verdana;
    font-size: 14px;
    font-weight: 600;
     }
	.cacheAlert {
    color: #1a66ff;
    font-family: verdana;
    font-size: 14px;
    font-weight: 600;
     }
	.cacheFont {
    color: #3c3c3c;
    font-family: verdana;
    font-size: 14px;
    font-weight: 100;
    font-style: italic;
     }
	h1 {
    color: #96588a;
    font-family: verdana;
    font-size: 18px;
    font-weight: 100;
	}
	h2 {
    color: #96588a;
	}
ul.checkmark li {
  font-size: 16px; 
  list-style-type: none;
  margin-bottom: 1em; 
  padding: 0.25em 0 0 2.5em; 
  position: relative; 
}

ul.checkmark li:before {
  content: \" \"; 
  display: block;
  border: solid 0.8em #71b02f; 
  border-radius: .8em; 
  height: 0;
  width: 0;
  position: absolute; 
  left: 0.5em;
  top: 40%; 
  margin-top: -0.5em;
}

ul.checkmark li:after {
  content: \" \";
  display: block;
  width: 0.3em; 
  height: 0.6em;
  border: solid white;
  border-width: 0 0.2em 0.2em 0;
  position: absolute;
  left: 1em;
  top: 40%;
  margin-top: -0.2em;
  -webkit-transform: rotate(45deg); 
  -moz-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
}

 </style>";
}

add_action('admin_head', 'my_custom_fonts');
