<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Product count: " . App\Models\Product::count() . "\n";
echo "Product count (query without is_available filter): " . App\Models\Product::count() . "\n";
