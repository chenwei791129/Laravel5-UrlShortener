<?php
$helpers = [
    'UrlHelper.php',
    'IpHelper.php',
    'ViewHelper.php',
    'DatabaseHelper.php'
];

// 載入 Helper 檔案
foreach ($helpers as $helperFileName) {
    include __DIR__ . '/' .$helperFileName;
}