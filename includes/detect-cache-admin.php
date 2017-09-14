<?php

echo "<center><h1> Detect Cache </h1></center>";

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