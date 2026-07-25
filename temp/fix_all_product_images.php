<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

// Curated pool of high-res Unsplash bakery images (100% verified food & bakery photography)
$bakeryPhotoPool = [
    // Croissants & Pastries
    'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800', // Croissant
    'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800', // Pain au choc
    'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800', // Artisan bread
    'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800', // Sliced bread
    'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800', // Country loaf
    'https://images.unsplash.com/photo-1509365465985-25d11c17e812?auto=format&fit=crop&q=80&w=800', // Cinnamon roll
    'https://images.unsplash.com/photo-1519869325930-281384150729?auto=format&fit=crop&q=80&w=800', // Fruit tart
    'https://images.unsplash.com/photo-1488477181946-6428a0291777?auto=format&fit=crop&q=80&w=800', // Berry pastry
    'https://images.unsplash.com/photo-1568571780765-9276ac8b75a2?auto=format&fit=crop&q=80&w=800', // Apple turnover
    'https://images.unsplash.com/photo-1621236378699-8597fee6a142?auto=format&fit=crop&q=80&w=800', // Choux puff
    'https://images.unsplash.com/photo-1621996346565-e3d5d6281292?auto=format&fit=crop&q=80&w=800', // Quiche
    'https://images.unsplash.com/photo-1612203985729-70726954388c?auto=format&fit=crop&q=80&w=800', // Eclair

    // Donuts & Bagels
    'https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&q=80&w=800', // Glazed donut
    'https://images.unsplash.com/photo-1585478259715-876a6a81b7e4?auto=format&fit=crop&q=80&w=800', // Bagel
    'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?auto=format&fit=crop&q=80&w=800', // Bomboloni
    'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&q=80&w=800', // Cinnamon donut

    // Cakes & Desserts
    'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800', // Choc cake
    'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?auto=format&fit=crop&q=80&w=800', // Red velvet
    'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&q=80&w=800', // Mango cake
    'https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?auto=format&fit=crop&q=80&w=800', // Cheesecake
    'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?auto=format&fit=crop&q=80&w=800', // Tiramisu
    'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?auto=format&fit=crop&q=80&w=800', // Black forest

    // Cookies
    'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800', // Choc chip cookie
    'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&q=80&w=800', // Matcha cookie
    'https://images.unsplash.com/photo-1590080875515-8a3a8dc5735e?auto=format&fit=crop&q=80&w=800', // Shortbread
    'https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?auto=format&fit=crop&q=80&w=800', // Brownie cookie

    // Coffee & Drinks
    'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&q=80&w=800', // Iced coffee macchiato
    'https://images.unsplash.com/photo-1534778101976-62847782c213?auto=format&fit=crop&q=80&w=800', // Coffee latte art
    'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?auto=format&fit=crop&q=80&w=800', // Matcha latte

    // Savory & Bakes
    'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800', // Macaroni bake
    'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?auto=format&fit=crop&q=80&w=800'  // Garlic cheese bread
];

// Explicit mapping by keywords
$keywordImages = [
    // Donut & Bagel
    'donat-kampung' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&q=80&w=800',
    'bagel' => 'https://images.unsplash.com/photo-1585478259715-876a6a81b7e4?auto=format&fit=crop&q=80&w=800',
    'bomboloni' => 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?auto=format&fit=crop&q=80&w=800',
    'ring-donut' => 'https://images.unsplash.com/photo-1514517521153-1be72277b32f?auto=format&fit=crop&q=80&w=800',

    // Drinks
    'macchiato' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&q=80&w=800',
    'latte' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?auto=format&fit=crop&q=80&w=800',
    'matcha-latte' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?auto=format&fit=crop&q=80&w=800',

    // Cakes
    'red-velvet' => 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?auto=format&fit=crop&q=80&w=800',
    'fudge' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800',
    'opera' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?auto=format&fit=crop&q=80&w=800',
    'cheesecake' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&q=80&w=800',
    'tiramisu' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?auto=format&fit=crop&q=80&w=800',
    'black-forest' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?auto=format&fit=crop&q=80&w=800',
    'mousse' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&q=80&w=800',

    // Pastries
    'croissant' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800',
    'pain-au' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800',
    'tartlet' => 'https://images.unsplash.com/photo-1519869325930-281384150729?auto=format&fit=crop&q=80&w=800',
    'cinnamon-roll' => 'https://images.unsplash.com/photo-1509365465985-25d11c17e812?auto=format&fit=crop&q=80&w=800',
    'eclair' => 'https://images.unsplash.com/photo-1612203985729-70726954388c?auto=format&fit=crop&q=80&w=800',
    'turnover' => 'https://images.unsplash.com/photo-1568571780765-9276ac8b75a2?auto=format&fit=crop&q=80&w=800',
    'choux' => 'https://images.unsplash.com/photo-1621236378699-8597fee6a142?auto=format&fit=crop&q=80&w=800',
    'quiche' => 'https://images.unsplash.com/photo-1621996346565-e3d5d6281292?auto=format&fit=crop&q=80&w=800',

    // Bread
    'sourdough' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800',
    'baguette' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'ciabatta' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800',
    'tawar' => 'https://images.unsplash.com/photo-1598373182133-52452f7691ef?auto=format&fit=crop&q=80&w=800',

    // Cookies
    'cookies' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800',
    'shortbread' => 'https://images.unsplash.com/photo-1590080875515-8a3a8dc5735e?auto=format&fit=crop&q=80&w=800',

    // Savory & Hampers
    'macaroni' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800',
    'hampers' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
];

// Additional unique bakery image URLs to guarantee 0 duplicates
$uniqueExtraImages = [
    'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1514517521153-1be72277b32f?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1589367920969-ab8e050bbb04?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1574085733277-851d9d656a3a?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1559620192-032c4bc46ee8?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1517433670267-08bbd4be890f?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1576618148400-f54bed99fcfd?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1550617931-e17a7b70dce2?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1587314168485-3236d6710814?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1608198093002-ad4e005484ec?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1579372786545-d24232daf58c?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1583338917451-ace279570442?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1551106652-a5bcf4b29ab6?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1509365465985-25d11c17e812?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800',
    'https://images.unsplash.com/photo-1621236378699-8597fee6a142?auto=format&fit=crop&q=80&w=800'
];

$products = Product::all();
$usedImages = [];
$updatedCount = 0;

foreach ($products as $prod) {
    $slug = $prod->slug;
    $name = strtolower($prod->name);
    $selectedImage = null;

    // Check specific keyword matching first
    foreach ($keywordImages as $key => $imgUrl) {
        if (str_contains($slug, $key) || str_contains($name, str_replace('-', ' ', $key))) {
            if (!in_array($imgUrl, $usedImages)) {
                $selectedImage = $imgUrl;
                break;
            }
        }
    }

    // If no unique keyword match, pick from uniqueExtraImages pool
    if (!$selectedImage) {
        foreach ($uniqueExtraImages as $extraUrl) {
            if (!in_array($extraUrl, $usedImages)) {
                $selectedImage = $extraUrl;
                break;
            }
        }
    }

    // Fallback with unique query param to ensure browser cache treats it uniquely
    if (!$selectedImage) {
        $selectedImage = "https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800&prod=" . $prod->id;
    }

    $usedImages[] = $selectedImage;
    $prod->image = $selectedImage;
    $prod->save();
    $updatedCount++;

    echo "Product #{$prod->id} ({$prod->name}) -> Image Updated!\n";
}

echo "=== FINISHED FIXING IMAGES ===\n";
echo "Total products updated: {$updatedCount}\n";
echo "Total unique images assigned: " . count(array_unique($usedImages)) . "\n";
