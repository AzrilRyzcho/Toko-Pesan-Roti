<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

$newCategories = [
    [
        'name' => 'Donat & Bagel',
        'slug' => 'donat-bagel',
        'products' => [
            [
                'name' => 'Donat Kampung Gula Halus',
                'price' => 12000,
                'stock' => 30,
                'description' => 'Donat kentang tradisional super empuk dengan taburan gula donat dingin yang manis lezat.',
                'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Everything Sesame Bagel',
                'price' => 24000,
                'stock' => 20,
                'description' => 'Bagel khas New York panggang bertekstur kenyal bertabur biji wijen, poppy seeds, dan garam laut.',
                'image' => 'https://images.unsplash.com/photo-1585478259715-876a6a81b7e4?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Donat Coklat Melted Bomboloni',
                'price' => 18000,
                'stock' => 25,
                'description' => 'Donat bomboloni Italia tanpa lubang dengan isian krim coklat belgia yang melimpah lumer.',
                'image' => 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Cinnamon Sugar Ring Donut',
                'price' => 14000,
                'stock' => 28,
                'description' => 'Donat cincang empuk berbalut campuran gula dan bubuk kayu manis beraroma harum.',
                'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&q=80&w=800'
            ]
        ]
    ],
    [
        'name' => 'Paket Gift & Hampers',
        'slug' => 'paket-gift-hampers',
        'products' => [
            [
                'name' => 'Hampers Artisanal Bread Basket',
                'price' => 250000,
                'stock' => 10,
                'description' => 'Paket keranjang bingkisan eksklusif berisi Sourdough, Baguette, Focaccia, dan Butter Spread buatan tangan.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Sweet Pastry Box Special Edition',
                'price' => 185000,
                'stock' => 15,
                'description' => 'Kotak hadiah cantik berisi 6 varian Croissant, Pain au Chocolat, dan Danish manis pilihan.',
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Signature Cookie Tin Gift Box',
                'price' => 210000,
                'stock' => 12,
                'description' => 'Biskuit tin kaleng klasik berisi 3 toples cookies artisan favorit untuk perayaan istimewa.',
                'image' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800'
            ]
        ]
    ],
    [
        'name' => 'Minuman & Kopi',
        'slug' => 'minuman-kopi',
        'products' => [
            [
                'name' => 'Iced Caramel Macchiato',
                'price' => 32000,
                'stock' => 40,
                'description' => 'Espresso arabika spesial dipadukan dengan susu segar cold-pressed dan sirup karamel bakar.',
                'image' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Artisan Oat Milk Latte',
                'price' => 35000,
                'stock' => 35,
                'description' => 'Kopi latte krimi lembut dengan susu oat organik, cocok untuk pasangan menikmati roti hangat.',
                'image' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Matcha Latte Uji Premium',
                'price' => 34000,
                'stock' => 30,
                'description' => 'Minuman teh hijau Matcha asli Jepang dari daerah Uji yang kaya antioksidan dan kental gurih.',
                'image' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?auto=format&fit=crop&q=80&w=800'
            ]
        ]
    ],
    [
        'name' => 'Roti Gluten-Free',
        'slug' => 'roti-gluten-free',
        'products' => [
            [
                'name' => 'Gluten-Free Almond Bread',
                'price' => 45000,
                'stock' => 12,
                'description' => 'Roti tawar gandum bebas gluten yang dibuat dari tepung almond murni dan minyak kelapa organik.',
                'image' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Gluten-Free Seeded Loaf',
                'price' => 48000,
                'stock' => 10,
                'description' => 'Roti sehat gluten-free penuh nutrisi dengan biji bunga matahari, pumpkin seeds, dan chia.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
            ]
        ]
    ],
    [
        'name' => 'Bakes & Savory',
        'slug' => 'bakes-savory',
        'products' => [
            [
                'name' => 'Macaroni Smoked Beef Cheese Bake',
                'price' => 38000,
                'stock' => 15,
                'description' => 'Sajian makaroni panggang dengan saus keju panggang lelehan cheddar dan daging sapi asap harum.',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Garlic Cheese Bread Pull-Apart',
                'price' => 32000,
                'stock' => 18,
                'description' => 'Roti gurih bakar dengan racikan mentega bawang putih pekat dan isian keju mozarella tarik.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
            ]
        ]
    ]
];

$addedCats = 0;
$addedProds = 0;

foreach ($newCategories as $cData) {
    $cat = Category::firstOrCreate(
        ['name' => $cData['name']],
        ['slug' => $cData['slug']]
    );

    if ($cat->wasRecentlyCreated) {
        $addedCats++;
    }

    foreach ($cData['products'] as $pData) {
        $slug = Str::slug($pData['name']);
        if (!Product::where('slug', $slug)->exists()) {
            Product::create([
                'name' => $pData['name'],
                'slug' => $slug,
                'category_id' => $cat->id,
                'price' => $pData['price'],
                'stock' => $pData['stock'],
                'description' => $pData['description'],
                'image' => $pData['image'],
            ]);
            $addedProds++;
        }
    }
}

echo "=== NEW CATEGORIES SEEDING ===\n";
echo "New categories added: {$addedCats}\n";
echo "New products added: {$addedProds}\n";
echo "Total categories in database: " . Category::count() . "\n";
echo "Total products in database: " . Product::count() . "\n\n";

foreach (Category::all() as $c) {
    echo "- {$c->name} ({$c->slug}) -> " . $c->products()->count() . " products\n";
}
