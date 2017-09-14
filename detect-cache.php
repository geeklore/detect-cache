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


add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    body, td, textarea, input, select {
      font-family: "Lucida Grande";
      font-size: 13px;
    } 
  </style>';
}

// function my_admin_theme_style() {
//     wp_enqueue_style('my-admin-theme', plugins_url('admin.css', __FILE__));
// }
// add_action('admin_enqueue_scripts', 'my_admin_theme_style');
// add_action('login_enqueue_scripts', 'my_admin_theme_style');


//     add_action( 'admin_menu', 'add_my_admin_menus' ); // hook so we can add menus to our admin left-hand menu

//     /**
//      * Create the administration menus in the left-hand nav and load the JavaScript conditionally only on that page
//      */
//     function add_my_admin_menus(){
//         $my_page = add_menu_page( 'Page Title', 'Menu Title', MY_ADMIN_CAPABILITY, 'menu-slug', 'show_page_content' );

//         // Load the JS conditionally
//         add_action( 'load-' . $my_page, 'load_admin_js' );
//     }

//     // This function is only called when our plugin's page loads!
//     function load_admin_js(){
//         // Unfortunately we can't just enqueue our scripts here - it's too early. So register against the proper action hook to do it
//         add_action( 'admin_enqueue_scripts', 'enqueue_admin_js' );
//     }

//     function enqueue_admin_js(){
//         // Isn't it nice to use dependencies and the already registered core js files?
//         wp_enqueue_script( 'my-script', INCLUDES_URI . '/js/my_script.js', array( 'jquery-ui-core', 'jquery-ui-tabs' ) );
//     }
// }