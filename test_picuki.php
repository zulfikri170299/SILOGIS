<?php
$html = @file_get_contents('https://morss.it/https://instagram.com/birologistik_ntb');
if ($html) {
    echo "Success: " . strlen($html) . " bytes\n";
    echo substr($html, 0, 100);
} else {
    echo "Failed";
}
