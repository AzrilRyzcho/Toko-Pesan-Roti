<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

$categories = Category::all()->keyBy('name');

// High-quality imagery from Unsplash for realistic bakery presentation
$images = [
    'pastry' => [
        'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
    ],
    'cakes' => [
        'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?auto=format&fit=crop&q=80&w=800'
    ],
    'bread' => [
        'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
    ],
    'cookies' => [
        'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1590080875515-8a3a8dc5735e?auto=format&fit=crop&q=80&w=800'
    ]
];

$bulkProducts = [
    // 🥐 Kue & Pastry (Expanded for User Request)
    [
        'name' => 'Eclair Coklat Lezat',
        'category' => 'Kue & Pastry',
        'price' => 24000,
        'stock' => 20,
        'description' => 'Pastry panjang khas Perancis dengan isian custard krim coklat pekat dan glaze coklat mengkilap.',
        'image' => $images['pastry'][0]
    ],
    [
        'name' => 'Fruit Tartlet Fresh Berries',
        'category' => 'Kue & Pastry',
        'price' => 27000,
        'stock' => 18,
        'description' => 'Tartlet renyah dengan isian diplomat cream manis dan buah-buahan segar pilihan.',
        'image' => $images['pastry'][1]
    ],
    [
        'name' => 'Cinnamon Roll Glaze Karamel',
        'category' => 'Kue & Pastry',
        'price' => 22000,
        'stock' => 25,
        'description' => 'Roll pastry bertabur bubuk kayu manis murni dengan saus karamel leleh dan cream cheese di atasnya.',
        'image' => $images['pastry'][2]
    ],
    [
        'name' => 'Apple Turnover Pastry',
        'category' => 'Kue & Pastry',
        'price' => 26000,
        'stock' => 15,
        'description' => 'Puff pastry renyah khas Eropa dengan isian potongan apel manis dan rempah kayu manis harum.',
        'image' => $images['pastry'][3]
    ],
    [
        'name' => 'Choux au Craquelin Vanila',
        'category' => 'Kue & Pastry',
        'price' => 20000,
        'stock' => 30,
        'description' => 'Kue sus dengan lapisan topping craquelin renyah dan isian krim vanila Bourbon halus.',
        'image' => $images['pastry'][0]
    ],
    [
        'name' => 'Quiche Lorraine Smoked Beef',
        'category' => 'Kue & Pastry',
        'price' => 35000,
        'stock' => 12,
        'description' => 'Pie gurih khas Perancis dengan campuran daging sapi asap, keju mozarella, dan telur panggang renyah.',
        'image' => $images['pastry'][1]
    ],

    // 🥖 Artisan Bread
    [
        'name' => 'Multigrain Seeded Sourdough',
        'category' => 'Artisan Bread',
        'price' => 52000,
        'stock' => 14,
        'description' => 'Roti sourdough fermentasi alami dengan campuran biji chia, kuaci bunga matahari, dan wijen hitam.',
        'image' => $images['bread'][0]
    ],
    [
        'name' => 'Olive Garlic Focaccia',
        'category' => 'Artisan Bread',
        'price' => 45000,
        'stock' => 10,
        'description' => 'Roti tradisional Italia dengan buah zaitun hitam, bawang putih panggang, dan minyak zaitun extra virgin.',
        'image' => $images['bread'][1]
    ],
    [
        'name' => 'Walnut Fig Country Loaf',
        'category' => 'Artisan Bread',
        'price' => 58000,
        'stock' => 8,
        'description' => 'Roti artisan pedesaan Perancis dengan isian kacang walnut renyah dan potongan buah ara manis.',
        'image' => $images['bread'][2]
    ],

    // 🎂 Premium Cakes
    [
        'name' => 'Tiramisu Mascarpone Spasial',
        'category' => 'Premium Cakes',
        'price' => 275000,
        'stock' => 7,
        'description' => 'Kue khas Italia dengan keju mascarpone impor, biskuit ladyfinger yang direndam espresso asli.',
        'image' => $images['cakes'][0]
    ],
    [
        'name' => 'Black Forest Gateau',
        'category' => 'Premium Cakes',
        'price' => 310000,
        'stock' => 6,
        'description' => 'Kue coklat spons berilapis krim vanila, buah ceri hitam segar, dan serutan coklat pekat melimpah.',
        'image' => $images['cakes'][1]
    ],
    [
        'name' => 'Lemon Blueberry Mille Crepe',
        'category' => 'Premium Cakes',
        'price' => 285000,
        'stock' => 9,
        'description' => 'Kue berlapis-lapis crepe halus dengan curd lemon segar dan selai buah blueberry asli.',
        'image' => $images['cakes'][2]
    ],

    // 🥐 French Pastries
    [
        'name' => 'Kouign-Amann Butter Pastry',
        'category' => 'French Pastries',
        'price' => 30000,
        'stock' => 16,
        'description' => 'Pastry khas Brittany Perancis yang berlapis mentega dengan lapisan gula karamel garing beraroma vanila.',
        'image' => $images['pastry'][2]
    ],
    [
        'name' => 'Cronut Nutella Hazelnut',
        'category' => 'French Pastries',
        'price' => 32000,
        'stock' => 20,
        'description' => 'Perpaduan croissant dan donat renyah dengan isian selai Nutella dan taburan kacang hazelnut panggang.',
        'image' => $images['pastry'][3]
    ],

    // 🍪 Signature Cookies
    [
        'name' => 'Red Velvet Cream Cheese Cookies',
        'category' => 'Signature Cookies',
        'price' => 85000,
        'stock' => 22,
        'description' => 'Soft cookies red velvet dengan isian keju lumer yang gurih manis melimpah.',
        'image' => $images['cookies'][0]
    ],
    [
        'name' => 'Double Dark Choc Fudge Cookies',
        'category' => 'Signature Cookies',
        'price' => 78000,
        'stock' => 24,
        'description' => 'Cookies coklat pekat double cocoa dengan lelehan fudge coklat di setiap gigitan.',
        'image' => $images['cookies'][1]
    ],

    // 🍞 Roti Manis
    [
        'name' => 'Roti Sobek Srikaya Pandan',
        'category' => 'Roti Manis',
        'price' => 22000,
        'stock' => 25,
        'description' => 'Roti sobek super lembut dengan aroma daun pandan asli dan selai srikaya buatan sendiri.',
        'image' => $images['bread'][1]
    ],
    [
        'name' => 'Roti Pisang Coklat Keju',
        'category' => 'Roti Manis',
        'price' => 17000,
        'stock' => 30,
        'description' => 'Roti manis empuk dengan isian pisang raja manis, coklat belgia, dan parutan keju cheddar.',
        'image' => $images['bread'][2]
    ],

    // 🍞 Roti Tawar
    [
        'name' => 'Roti Tawar Milk Toast Jepang (Shokupan)',
        'category' => 'Roti Tawar',
        'price' => 38000,
        'stock' => 15,
        'description' => 'Roti tawar susu khas Jepang super empuk dan kenyal dengan aroma susu Hokkaido yang khas.',
        'image' => $images['bread'][0]
    ]
];

$added = 0;
foreach ($bulkProducts as $pData) {
    // Find or create category
    $catName = $pData['category'];
    $cat = $categories->get($catName) ?: Category::firstOrCreate(
        ['name' => $catName],
        ['slug' => Str::slug($catName)]
    );

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
        $added++;
        echo "Added: {$pData['name']} -> {$catName}\n";
    }
}

echo "=== SEEDING SUMMARY ===\n";
echo "New products added: {$added}\n";
echo "Total products in database: " . Product::count() . "\n";

foreach (Category::all() as $c) {
    echo "Category: {$c->name} (Slug: {$c->slug}) -> " . $c->products()->count() . " products\n";
}
