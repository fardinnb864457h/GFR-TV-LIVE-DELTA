<?php
// ===== CONFIG =====
$source = "https://epiconvh.akamaized.net/live/gubbare/master.m3u8";
$base   = "https://epiconvh.akamaized.net/live/gubbare/";

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/vnd.apple.mpegurl");

// Fetch m3u8
$ch = curl_init($source);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$data = curl_exec($ch);
curl_close($ch);

// Fix relative paths
$lines = explode("\n", $data);
$output = "";

foreach ($lines as $line) {
    $line = trim($line);

    if ($line === "" || strpos($line, "#") === 0) {
        $output .= $line . "\n";
    } else {
        if (strpos($line, "http") === 0) {
            $output .= $line . "\n";
        } else {
            $output .= $base . $line . "\n";
        }
    }
}

echo $output;
?>