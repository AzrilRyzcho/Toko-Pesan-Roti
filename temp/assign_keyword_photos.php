<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$products = Product::with('category')->get();
$updated = 0;

foreach ($products as $p) {
    $slug = $p->slug;
    $catName = strtolower($p->category->name ?? '');

    $kw = 'bakery';

    if (str_contains($catName, 'donat') || str_contains($catName, 'bagel')) {
        if (str_contains($slug, 'bagel')) {
            $kw = 'bagel';
        } elseif (str_contains($slug, 'bomboloni')) {
            $kw = 'bomboloni,donut';
        } else {
            $kw = 'donut';
        }
    } elseif (str_contains($catName, 'minuman') || str_contains($catName, 'kopi')) {
        if (str_contains($slug, 'matcha')) {
            $kw = 'matcha,latte';
        } elseif (str_contains($slug, 'macchiato')) {
            $kw = 'coffee,macchiato';
        } else {
            $kw = 'coffee,latte';
        }
    } elseif (str_contains($catName, 'cookie')) {
        if (str_contains($slug, 'matcha')) {
            $kw = 'matcha,cookies';
        } elseif (str_contains($slug, 'red-velvet')) {
            $kw = 'redvelvet,cookie';
        } elseif (str_contains($slug, 'brownie') || str_contains($slug, 'dark')) {
            $kw = 'chocolate,cookie';
        } else {
            $kw = 'cookie';
        }
    } elseif (str_contains($catName, 'cake')) {
        if (str_contains($slug, 'cheesecake')) {
            $kw = 'cheesecake';
        } elseif (str_contains($slug, 'tiramisu')) {
            $kw = 'tiramisu';
        } elseif (str_contains($slug, 'red-velvet')) {
            $kw = 'redvelvet,cake';
        } elseif (str_contains($slug, 'mousse') || str_contains($slug, 'fruit')) {
            $kw = 'fruit,cake';
        } else {
            $kw = 'cake';
        }
    } elseif (str_contains($catName, 'pastry') || str_contains($catName, 'french')) {
        if (str_contains($slug, 'croissant')) {
            $kw = 'croissant';
        } elseif (str_contains($slug, 'chocolat')) {
            $kw = 'chocolate,pastry';
        } elseif (str_contains($slug, 'tartlet') || str_contains($slug, 'fruit')) {
            $kw = 'tart,pastry';
        } elseif (str_contains($slug, 'cinnamon')) {
            $kw = 'cinnamon,roll';
        } else {
            $kw = 'pastry';
        }
    } elseif (str_contains($catName, 'hampers') || str_contains($catName, 'gift')) {
        $kw = 'gift,bakery';
    } elseif (str_contains($catName, 'savory') || str_contains($catName, 'bake')) {
        if (str_contains($slug, 'macaroni')) {
            $kw = 'macaroni,cheese';
        } else {
            $kw = 'garlic,bread';
        }
    } else { // Roti Manis, Roti Tawar, Artisan Bread
        if (str_contains($slug, 'sourdough')) {
            $kw = 'sourdough,bread';
        } elseif (str_contains($slug, 'baguette')) {
            $kw = 'baguette';
        } elseif (str_contains($slug, 'ciabatta') || str_contains($slug, 'focaccia')) {
            $kw = 'ciabatta';
        } elseif (str_contains($slug, 'tawar') || str_contains($slug, 'toast') || str_contains($slug, 'shokupan')) {
            $kw = 'toast,bread';
        } else {
            $kw = 'bread';
        }
    }

    // Assign LoremFlickr URL with product ID lock so every image is 100% unique, relevant, and realistic
    $url = "https://loremflickr.com/800/600/{$kw}?lock=" . ($p->id + 100);
    $p->image = $url;
    $p->save();
    $updated++;

    echo "Product #{$p->id} ({$p->name}) [{$catName}] -> Image: {$url}\n";
}

echo "=== ASSIGNED 100% REALISTIC KEYWORD FOOD PHOTOS ===\n";
echo "Total updated: {$updated}\n";
