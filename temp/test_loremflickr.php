<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$keywords = ['donut', 'bagel', 'croissant', 'cake', 'cookie', 'coffee', 'bread', 'pastry', 'cheesecake'];

foreach ($keywords as $i => $kw) {
    $url = "https://loremflickr.com/800/600/{$kw}?lock=" . ($i + 10);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    echo "Keyword: {$kw} -> HTTP {$code} -> Final URL: {$effectiveUrl}\n";
}
