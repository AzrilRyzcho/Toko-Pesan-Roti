<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\File;

$publicDir = public_path('images/products');
if (!File::exists($publicDir)) {
    File::makeDirectory($publicDir, 0755, true);
}

// Map generated images to product slugs
$generatedMap = [
    'donat-kampung-gula-halus' => 'donat_kampung_gula_halus_1784892458119.png',
    'everything-sesame-bagel' => 'everything_sesame_bagel_1784892521096.png',
    'donat-coklat-melted-bomboloni' => 'donat_coklat_melted_bomboloni_1784892558924.png',
    'cinnamon-sugar-ring-donut' => 'cinnamon_sugar_ring_donut_1784892594350.png',
    'iced-caramel-macchiato' => 'iced_caramel_macchiato_1784892627114.png',
    'artisan-oat-milk-latte' => 'artisan_oat_milk_latte_1784892664551.png',
    'matcha-latte-uji-premium' => 'matcha_latte_uji_premium_1784892698177.png',
    'triple-choc-brownie-cookies' => 'triple_choc_brownie_cookies_1784892734949.png',
    'red-velvet-cream-cheese-cookies' => 'red_velvet_cream_cheese_cookies_1784892769655.png',
    'double-dark-choc-fudge-cookies' => 'double_dark_choc_fudge_cookies_1784892804017.png',
    'pistachio-cranberry-shortbread' => 'pistachio_cranberry_shortbread_1784892838354.png'
];

$artifactsDir = 'C:\Users\prana\.gemini\antigravity-ide\brain\fd18abfc-b8c3-4969-9bb3-8209fec5b037';

foreach ($generatedMap as $slug => $fileName) {
    $srcPath = $artifactsDir . '\\' . $fileName;
    $destFileName = $slug . '.png';
    $destPath = $publicDir . '/' . $destFileName;

    if (File::exists($srcPath)) {
        File::copy($srcPath, $destPath);
        $prod = Product::where('slug', $slug)->first();
        if ($prod) {
            $prod->image = 'images/products/' . $destFileName;
            $prod->save();
            echo "Assigned local image to Product #{$prod->id} ({$prod->name}) -> images/products/{$destFileName}\n";
        }
    } else {
        echo "Source file missing: {$srcPath}\n";
    }
}

// Also update French Pastries products with curated high resolution local/verified links
$pastriesMap = [
    'kouign-amann-butter-pastry' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800',
    'cronut-nutella-hazelnut' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?w=800',
    'pain-au-chocolat-belgia' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?w=800',
    'almond-croissant-panggang' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800',
    'danish-strawberry-cream' => 'https://images.unsplash.com/photo-1519869325930-281384150729?w=800',
    'premium-butter-croissant' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800',
    'almond-croissant-royale' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800'
];

foreach ($pastriesMap as $slug => $imgUrl) {
    $p = Product::where('slug', $slug)->first();
    if ($p) {
        $p->image = $imgUrl;
        $p->save();
        echo "Updated French Pastry #{$p->id} ({$p->name}) -> {$imgUrl}\n";
    }
}

echo "=== ASSIGNMENT COMPLETED ===\n";
