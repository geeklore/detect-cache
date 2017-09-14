<?php
// Check the headers for any clues as to caching and proxies. 
// Also check the plugins and filesystem 
// for anything that might indicate caching.

echo "<div class=wrap>";
echo "<h1> Detect Cache </h1>";

$url = site_url();

echo "<h3> Detecting Cache In Headers </h3>";

// header_cache_found is set to 0 so we can display a not found message if set to 0
$header_cache_found = '0';
// get_headers is used to ... get the headers and then a foreach is used to 
// grab the values. Each is tested for a specific string.
$header = get_headers($url);
foreach ($header as $key=>$value) {
// Is there X-Cache?
    if (stripos($value, "cache") !== false) {
    	echo "X-Cache Directive Detected in header.";
    	echo "<br>";
    	echo "Line : $key: <b>$value</b>";
      	echo "<br>";
      	$header_cache_found = '1';
// Is CloudFlare invoved?
    }elseif (stripos($value, "cloudflare") !== false) {
    	echo "CloudFlare Detected";
    	echo "<br>";
    	echo "<b>$value</b>";
      	$header_cache_found = '1';
// Is there a Proxy involved?
    }elseif (stripos($value, "proxy") !== false) {
    	echo "Proxy Detected";
    	echo "<br>";
    	echo "$value";
      	$header_cache_found = '1';
// Is there a Varnish server involved?
    }elseif (stripos($value, "varnish") !== false) {
    	echo "Varnish Reverse Proxy Detected";
    	echo "<br>";
    	echo "$value";
      	$header_cache_found = '1';
// Is there actualy Cache-Control set? - would be nice to check for the time and print.
    }elseif (stripos($value, "Cache-Control") !== false) {
    	echo "Cache-Control detected";
    	echo "<br>";
    	echo "$value";
      	$header_cache_found = '1';
	} 
}

// Did we find any headers with "cache" in the name? If not, say so.
if ($header_cache_found == '0'){
	echo "No Caching detected in headers";
}


echo "<h3> Detecting Cache Via Local FileSystem </h3>";

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
    	echo "Possible caching diectory detected";
    	echo "<br>";
    	echo "Directory located: <b>$path$targetdir/$value</b>";
    	$filesystem_cache_found = '1';
    }
}
// Did we find any folders with "cache" in the name? If not, say so.
if ($filesystem_cache_found == '0'){
	echo "No Caching folders found in the wp-content directory";
}

echo "<h3> Looking for possible caching plugins </h3>";

// wp_get_active_and_valid_plugins gets the active plugins, save to an empty array
$all_active_plugins = wp_get_active_and_valid_plugins();

/// plugin_cache_found set to 0 so we can display a not found message if 0
$plugin_cache_found = '0';
foreach ($all_active_plugins as $key=>$value) {
    if( (stripos($value, "cache") !== false) && (stripos($value, "detect-cache") == false)) {
    	echo "Possible caching plugin detected";
    	echo "<br>";
    	//
    	// Would like to show just the name instead of the path to php file
    	//
    	echo "Line : $key: <b>$value</b>";
    	$plugin_cache_found = '1';
    }
}


if($plugin_cache_found == '0') {
	echo "No Caching plugins were found";
}


echo "</div>";
