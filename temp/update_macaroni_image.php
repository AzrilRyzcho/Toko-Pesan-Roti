<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\File;

$src = 'C:\Users\prana\.gemini\antigravity-ide\brain\fd18abfc-b8c3-4969-9bb3-8209fec5b037\macaroni_smoked_beef_cheese_bake_1784895862374.png';
$dest = public_path('images/products/macaroni-smoked-beef-cheese-bake.png');

if (File::exists($src)) {
    File::copy($src, $dest);
    $prod = Product::where('slug', 'macaroni-smoked-beef-cheese-bake')->first();
    if ($prod) {
        $prod->image = 'images/products/macaroni-smoked-beef-cheese-bake.png';
        $prod->save();
        echo "Successfully updated Product #{$prod->id} ({$prod->name}) with realistic Macaroni Schotel image!\n";
    } else {
        echo "Product not found by slug.\n";
    }
} else {
    echo "Source image not found.\n";
}
