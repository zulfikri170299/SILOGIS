<?php

function test_url($url) {
    echo "Testing $url\n";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $html = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "Status: $status | Length: " . strlen($html) . "\n";
    if ($status == 200 && strlen($html) > 1000) {
        return $html;
    }
    return false;
}

// Test Picuki
$picuki = test_url('https://www.picuki.com/profile/birologistik_ntb');
if ($picuki) {
    if (preg_match_all('/<div class="box-photo">.*?<a href="([^"]+)".*?<img.*?src="([^"]+)".*?<div class="photo-description">([^<]+)<\/div>/s', $picuki, $matches)) {
        echo "Picuki extracted " . count($matches[0]) . " items!\n";
    } else {
        echo "Picuki regex failed.\n";
    }
}

// Test Dumpor
$dumpor = test_url('https://dumpoir.com/v/birologistik_ntb');

// Test rss.shab.lol
$rss = test_url('https://rss.shab.lol/instagram/user/birologistik_ntb');

// Test morss
$morss = test_url('https://morss.it/https://instagram.com/birologistik_ntb');
