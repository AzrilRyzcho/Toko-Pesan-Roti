<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

echo "=== FINAL PRODUCT IMAGES CHECK ===\n";
foreach (Product::with('category')->get() as $p) {
    $cat = $p->category->name ?? 'Uncategorized';
    echo "ID #{$p->id} | Name: {$p->name} | Cat: [{$cat}] | Image: {$p->image}\n";
}
