<?php

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

printf("<div class=wrap>");
printf("<h1> Detect Cache </h1>");

$url = site_url();

printf("<h2> Detecting cache in HTTP headers </h2>");

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
    	printf("<span class='cacheDetected'>X-Cache directive <span class='cacheAlert'>detected</span> in header.</span><br>");
    	printf("<span class='cacheFont'>Line : $key: <b>$value</b></span><br>");
      	$header_cache_found = '1';
// Is CloudFlare invoved?
    }elseif (stripos($value, "cloudflare") !== false) {
    	printf("<span class='cacheDetected'>CloudFlare</span> <span class='cacheAlert'>detected</span><br>");
    	printf("<span class='cacheFont'><b>$value</b>");
      	$header_cache_found = '1';
// Is there a Proxy involved?
    }elseif (stripos($value, "proxy") !== false) {
    	printf("<span class='cacheDetected'>Proxy</span> <span class='cacheAlert'>detected</span><br>");
    	printf("<span class='cacheFont'>$value</span>");
      	$header_cache_found = '1';
// Is there a Varnish server involved?
    }elseif (stripos($value, "varnish") !== false) {
    	printf("<span class='cacheDetected'>Varnish Reverse Proxy</span> <span class='cacheAlert'>detected</span></span><br>");
    	printf("<span class='cacheFont'>$value</span>");
      	$header_cache_found = '1';
// Is there actualy Cache-Control set? - would be nice to check for the time and print.
    }elseif (stripos($value, "Cache-Control") !== false) {
    	printf("<span class='cacheDetected'>Cache-Control</span> <span class='cacheAlert'>detected</span><br>");
    	printf("<span class='cacheFont'>$value</span>");
      	$header_cache_found = '1';
	} 
}


// Did we find any headers with "cache" in the name? If not, say so.
if ($header_cache_found == '0'){
	printf("No Caching detected in headers");
}

printf("<h2> Detecting cache folders in the wp-content directory</h2>");

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
    	printf("<span class='cacheDetected'>Possible caching directory</span> <span class='cacheAlert'>detected</span><br>");
    	printf("<span class='cacheFont'>Directory located: <b>$path$targetdir/$value</b></span>");
    	$filesystem_cache_found = '1';
    }
}
// Did we find any folders with "cache" in the name? If not, say so.
if ($filesystem_cache_found == '0'){
printf("
<ul class='checkmark'>
  <li class='tick'>No Caching folders detected in the wp-content directory.</li>
  </ul>
  ");
}

printf("<h2> Detecting caching plugins </h2>");

// wp_get_active_and_valid_plugins gets the active plugins, save to an empty array
$all_active_plugins = wp_get_active_and_valid_plugins();

/// plugin_cache_found set to 0 so we can display a not found message if 0
$plugin_cache_found = '0';
foreach ($all_active_plugins as $key=>$value) {
    if( (stripos($value, "cache") !== false) && (stripos($value, "detect-cache") == false)) {
    	printf("<span class=cacheDetected>Caching or cache related plugin</span> <span class='cacheAlert'>detected</span><br>");
    	//
    	// Would like to show just the name instead of the path to php file
    	//
    	printf("<b>$value</b>");
    	$plugin_cache_found = '1';
    }
}


      // $key2 = 13;
      // $value2 = $all_active_plugins[$key2];
      // printf($value2);


print_r($all_active_plugins);

if($plugin_cache_found == '0') {
printf("
<ul class='checkmark'>
  <li class='tick'>No caching plugins were detected.</li>
  </ul>
  ");
}

printf("</div>");
