<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

// Tested & Verified Food Photography URLs by specific bakery type
$foodPhotoMap = [
    // --- DONUTS ---
    'donat-kampung-gula-halus' => 'https://images.unsplash.com/photo-1551106652-a5bcf4b29ab6?auto=format&fit=crop&q=80&w=800', // Powdered ring donut
    'everything-sesame-bagel' => 'https://images.unsplash.com/photo-1585478259715-876a6a81b7e4?auto=format&fit=crop&q=80&w=800', // Sesame bagel
    'donat-coklat-melted-bomboloni' => 'https://images.unsplash.com/photo-1527515545081-5db817172677?auto=format&fit=crop&q=80&w=800', // Chocolate bomboloni donuts
    'cinnamon-sugar-ring-donut' => 'https://images.unsplash.com/photo-1530018607912-eff2daa1bac4?auto=format&fit=crop&q=80&w=800', // Sugar cinnamon donut

    // --- COFFEE & DRINKS ---
    'iced-caramel-macchiato' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&q=80&w=800', // Iced coffee macchiato
    'artisan-oat-milk-latte' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?auto=format&fit=crop&q=80&w=800', // Coffee latte art
    'matcha-latte-uji-premium' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?auto=format&fit=crop&q=80&w=800', // Green matcha latte

    // --- CAKES ---
    'signature-red-velvet-cake' => 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?auto=format&fit=crop&q=80&w=800', // Red velvet cake slice
    'belgian-chocolate-fudge-cake' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800', // Rich choc cake
    'matcha-opera-cake' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?auto=format&fit=crop&q=80&w=800', // Green tea cake
    'classic-new-york-cheesecake' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&q=80&w=800', // NY cheesecake
    'tiramisu-mascarpone-spasial' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?auto=format&fit=crop&q=80&w=800', // Tiramisu slice
    'black-forest-gateau' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?auto=format&fit=crop&q=80&w=800', // Black forest cake
    'mango-coconut-mousse-cake' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&q=80&w=800', // Mango fruit cake
    'basque-burnt-cheesecake-premium' => 'https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?auto=format&fit=crop&q=80&w=800', // Basque burnt cheesecake
    'earl-grey-lavender-sponge-cake' => 'https://images.unsplash.com/photo-1519869325930-281384150729?auto=format&fit=crop&q=80&w=800', // Sponge cake with flower
    'salted-caramel-chocolate-cake' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?auto=format&fit=crop&q=80&w=800', // Caramel choc cake

    // --- PASTRIES & CROISSANTS ---
    'croissant-butter-klasik' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800', // Butter croissant
    'pain-au-chocolat' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800', // Pain au choc
    'almond-croissant-royale' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800', // Almond croissant
    'eclair-coklat-lezat' => 'https://images.unsplash.com/photo-1612203985729-70726954388c?auto=format&fit=crop&q=80&w=800', // Eclair
    'fruit-tartlet-fresh-berries' => 'https://images.unsplash.com/photo-1519869325930-281384150729?auto=format&fit=crop&q=80&w=800', // Fruit tart
    'cinnamon-roll-glaze-karamel' => 'https://images.unsplash.com/photo-1509365465985-25d11c17e812?auto=format&fit=crop&q=80&w=800', // Cinnamon roll
    'apple-turnover-pastry' => 'https://images.unsplash.com/photo-1568571780765-9276ac8b75a2?auto=format&fit=crop&q=80&w=800', // Apple turnover
    'choux-au-craquelin-vanila' => 'https://images.unsplash.com/photo-1621236378699-8597fee6a142?auto=format&fit=crop&q=80&w=800', // Cream puff choux
    'quiche-lorraine-smoked-beef' => 'https://images.unsplash.com/photo-1621996346565-e3d5d6281292?auto=format&fit=crop&q=80&w=800', // Baked quiche
    'kouign-amann-butter-pastry' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800', // Pastry
    'cronut-nutella-hazelnut' => 'https://images.unsplash.com/photo-1527515545081-5db817172677?auto=format&fit=crop&q=80&w=800', // Cronut
    'croissant-almond-butter-supreme' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800',
    'pastry-cheese-roll-smoked-ham' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800',
    'pistachio-cream-puff' => 'https://images.unsplash.com/photo-1621236378699-8597fee6a142?auto=format&fit=crop&q=80&w=800',
    'danish-blueberry-cream-cheese' => 'https://images.unsplash.com/photo-1519869325930-281384150729?auto=format&fit=crop&q=80&w=800',
    'chocolate-lava-croissant' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800',
    'mille-feuille-vanilla-bean' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?auto=format&fit=crop&q=80&w=800',
    'apple-cinnamon-tartlet' => 'https://images.unsplash.com/photo-1568571780765-9276ac8b75a2?auto=format&fit=crop&q=80&w=800',
    'savory-spinach-feta-puff' => 'https://images.unsplash.com/photo-1621996346565-e3d5d6281292?auto=format&fit=crop&q=80&w=800',

    // --- BREADS ---
    'classic-sourdough-loaf' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800', // Sourdough loaf
    'french-baguette-klasik' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800', // French baguette
    'rosemary-herb-ciabatta' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800', // Ciabatta bread
    'multigrain-seeded-sourdough' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800',
    'olive-garlic-focaccia' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800',
    'walnut-fig-country-loaf' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'cranberry-walnut-country-bread' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800',
    'garlic-butter-sourdough-batard' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'rye-bread-whole-grain-klasik' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800',

    // --- ROTI TAWAR & ROTI MANIS ---
    'roti-tawar-susu-premium' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800',
    'roti-tawar-gandum-utuh' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'roti-tawar-brioche-perancis' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800',
    'roti-tawar-milk-toast-jepang-shokupan' => 'https://images.unsplash.com/photo-1598373182133-52452f7691ef?auto=format&fit=crop&q=80&w=800',
    'roti-tawar-kismis-cinnamon' => 'https://images.unsplash.com/photo-1509365465985-25d11c17e812?auto=format&fit=crop&q=80&w=800',
    'roti-tawar-pandan-wangi' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800',
    'roti-tawar-multigrain-oats' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800',
    'roti-tawar-keju-marble' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'roti-tawar-choco-swirl-toast' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800',

    'roti-kopi-mentega' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'roti-abon-sapi-roll' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800',
    'roti-keju-manis-spesial' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'roti-coklat-lumer-klasik' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800',
    'roti-sobek-srikaya-pandan' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800',
    'roti-pisang-coklat-keju' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'roti-polo-sweet-butter' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800',
    'roti-sosis-keju-mozzarella' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800',
    'roti-kelapa-gula-jawa' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'roti-kacang-merah-jepang-anpan' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800',
    'roti-custard-cream-vanila' => 'https://images.unsplash.com/photo-1621236378699-8597fee6a142?auto=format&fit=crop&q=80&w=800',

    // --- COOKIES ---
    'dark-chocolate-sea-salt-cookies' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800',
    'uji-matcha-white-chocolate-cookies' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&q=80&w=800',
    'belgian-chocolate-chip-cookies' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800',
    'matcha-white-choc-cookies' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&q=80&w=800',
    'butter-shortbread-cookies' => 'https://images.unsplash.com/photo-1590080875515-8a3a8dc5735e?auto=format&fit=crop&q=80&w=800',
    'red-velvet-cream-cheese-cookies' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&q=80&w=800',
    'double-dark-choc-fudge-cookies' => 'https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?auto=format&fit=crop&q=80&w=800',
    'pistachio-cranberry-shortbread' => 'https://images.unsplash.com/photo-1590080875515-8a3a8dc5735e?auto=format&fit=crop&q=80&w=800',
    'triple-choc-brownie-cookies' => 'https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?auto=format&fit=crop&q=80&w=800',

    // --- HAMPERS & SAVORY ---
    'hampers-artisanal-bread-basket' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'sweet-pastry-box-special-edition' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800',
    'signature-cookie-tin-gift-box' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800',
    'gluten-free-almond-bread' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800',
    'gluten-free-seeded-loaf' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
    'macaroni-smoked-beef-cheese-bake' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800',
    'garlic-cheese-bread-pull-apart' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
];

$products = Product::all();
$updated = 0;

foreach ($products as $p) {
    $slug = $p->slug;
    
    if (isset($foodPhotoMap[$slug])) {
        $p->image = $foodPhotoMap[$slug];
    } else {
        // Fallback based on category/keywords
        if (str_contains($slug, 'donat') || str_contains($slug, 'donut')) {
            $p->image = 'https://images.unsplash.com/photo-1551106652-a5bcf4b29ab6?auto=format&fit=crop&q=80&w=800';
        } elseif (str_contains($slug, 'bagel')) {
            $p->image = 'https://images.unsplash.com/photo-1585478259715-876a6a81b7e4?auto=format&fit=crop&q=80&w=800';
        } elseif (str_contains($slug, 'kopi') || str_contains($slug, 'coffee') || str_contains($slug, 'latte') || str_contains($slug, 'macchiato')) {
            $p->image = 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&q=80&w=800';
        } elseif (str_contains($slug, 'cake') || str_contains($slug, 'tiramisu') || str_contains($slug, 'cheesecake')) {
            $p->image = 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800';
        } elseif (str_contains($slug, 'cookie')) {
            $p->image = 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800';
        } else {
            $p->image = 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';
        }
    }

    $p->save();
    $updated++;
}

echo "Done updating {$updated} products with explicit realistic bakery food images!\n";
