<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

$categories = Category::all()->keyBy('name');

$megaProducts = [
    // 🥐 Kue & Pastry (Add 8 more)
    [
        'name' => 'Croissant Almond Butter Supreme',
        'category' => 'Kue & Pastry',
        'price' => 34000,
        'stock' => 20,
        'description' => 'Croissant mentega berlapis tebal dengan krim almond gurih dan taburan almond panggang renyah.',
        'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Pastry Cheese Roll Smoked Ham',
        'category' => 'Kue & Pastry',
        'price' => 29000,
        'stock' => 18,
        'description' => 'Puff pastry gulung dengan isian keju mozarella leleh dan potongan daging asap berkualitias.',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Pistachio Cream Puff',
        'category' => 'Kue & Pastry',
        'price' => 26000,
        'stock' => 25,
        'description' => 'Kue sus Perancis dengan isian krim kacang pistachio asli dan parutan coklat putih di atasnya.',
        'image' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Danish Blueberry Cream Cheese',
        'category' => 'Kue & Pastry',
        'price' => 31000,
        'stock' => 15,
        'description' => 'Pastry Danish renyah bertabur blueberry segar dan krim keju melimpah yang manis gurih.',
        'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Chocolate Lava Croissant',
        'category' => 'Kue & Pastry',
        'price' => 33000,
        'stock' => 22,
        'description' => 'Croissant coklat hitam dengan isian lelehan coklat lava Belgia hangat yang melimpah.',
        'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Mille-Feuille Vanilla Bean',
        'category' => 'Kue & Pastry',
        'price' => 38000,
        'stock' => 12,
        'description' => 'Kue lapis Perancis berlapis-lapis pastry garing dengan isian diplomat cream vanila Madagascar.',
        'image' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Apple Cinnamon Tartlet',
        'category' => 'Kue & Pastry',
        'price' => 28000,
        'stock' => 16,
        'description' => 'Tartlet mini berisikan apel caramelized yang dipanggang bersama bubuk kayu manis manis gurih.',
        'image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Savory Spinach Feta Puff',
        'category' => 'Kue & Pastry',
        'price' => 27000,
        'stock' => 14,
        'description' => 'Puff pastry gurih berisikan potongan bayam organik dan keju feta Yunani panggang harum.',
        'image' => 'https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?auto=format&fit=crop&q=80&w=800'
    ],

    // 🍞 Roti Tawar (Add 6 more)
    [
        'name' => 'Roti Tawar Kismis Cinnamon',
        'category' => 'Roti Tawar',
        'price' => 35000,
        'stock' => 20,
        'description' => 'Roti tawar lembut kaya akan buah kismis pilihan dan keharuman kayu manis yang menenangkan.',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Roti Tawar Pandan Wangi',
        'category' => 'Roti Tawar',
        'price' => 30000,
        'stock' => 25,
        'description' => 'Roti tawar ekstra lembut dengan aroma alami sari daun pandan asli tanpa pewarna buatan.',
        'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Roti Tawar Multigrain Oats',
        'category' => 'Roti Tawar',
        'price' => 36000,
        'stock' => 18,
        'description' => 'Roti tawar gandum lengkap dengan taburan biji oat, flaxseed, dan biji wijen organik.',
        'image' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Roti Tawar Keju Marble',
        'category' => 'Roti Tawar',
        'price' => 39000,
        'stock' => 15,
        'description' => 'Roti tawar spesial dengan lelehan keju parut di dalam guratan marmer roti yang gurih.',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Roti Tawar Choco Swirl Toast',
        'category' => 'Roti Tawar',
        'price' => 37000,
        'stock' => 16,
        'description' => 'Roti tawar lembut dengan ulir coklat pekat yang memberikan rasa manis seimbang.',
        'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800'
    ],

    // 🥖 Roti Manis (Add 6 more)
    [
        'name' => 'Roti Polo Sweet Butter',
        'category' => 'Roti Manis',
        'price' => 17000,
        'stock' => 28,
        'description' => 'Roti manis dengan krust topping renyah manis manis beraroma mentega gurih ala Hong Kong.',
        'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Roti Sosis Keju Mozzarella',
        'category' => 'Roti Manis',
        'price' => 20000,
        'stock' => 22,
        'description' => 'Roti manis empuk berisi sosis sapi tebal dan lelehan keju mozzarella serta saus tomat spesial.',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Roti Kelapa Gula Jawa',
        'category' => 'Roti Manis',
        'price' => 16000,
        'stock' => 30,
        'description' => 'Roti manis tradisional berisikan parutan kelapa muda dan gula merah aren murni yang legit.',
        'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Roti Kacang Merah Jepang (Anpan)',
        'category' => 'Roti Manis',
        'price' => 18000,
        'stock' => 24,
        'description' => 'Roti manis khas Jepang dengan isian pasta azuki kacang merah halus yang lembut dan manis alami.',
        'image' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Roti Custard Cream Vanila',
        'category' => 'Roti Manis',
        'price' => 17000,
        'stock' => 26,
        'description' => 'Roti manis berisi krim vla vanila lembut yang dingin dan meleleh harum di mulut.',
        'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800'
    ],

    // 🥖 Artisan Bread (Add 5 more)
    [
        'name' => 'Cranberry Walnut Country Bread',
        'category' => 'Artisan Bread',
        'price' => 54000,
        'stock' => 12,
        'description' => 'Roti artisan pedesaan dengan asam manis kismis cranberry dan irisan kacang walnut panggang.',
        'image' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Garlic Butter Sourdough Batard',
        'category' => 'Artisan Bread',
        'price' => 48000,
        'stock' => 15,
        'description' => 'Roti sourdough asam alami yang diolesi mentega bawang putih dan peterseli harum.',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Rye Bread Whole Grain Klasik',
        'category' => 'Artisan Bread',
        'price' => 50000,
        'stock' => 10,
        'description' => 'Roti rye gandum hitam khas Eropa Utara dengan aroma rempah biji caraway yang otentik.',
        'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
    ],

    // 🎂 Premium Cakes (Add 4 more)
    [
        'name' => 'Basque Burnt Cheesecake Premium',
        'category' => 'Premium Cakes',
        'price' => 320000,
        'stock' => 6,
        'description' => 'Cheesecake panggang khas Basque Spanyol dengan bagian atas gosong karamelized dan tengahnya yang creamy.',
        'image' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Earl Grey Lavender Sponge Cake',
        'category' => 'Premium Cakes',
        'price' => 290000,
        'stock' => 8,
        'description' => 'Kue spons ringan beraroma teh Earl Grey Perancis dan keharuman ekstrak bunga lavender.',
        'image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Salted Caramel Chocolate Cake',
        'category' => 'Premium Cakes',
        'price' => 305000,
        'stock' => 7,
        'description' => 'Kue coklat pekat berlapis krim karamel garam gurih dan ganache coklat hitam melimpah.',
        'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800'
    ],

    // 🍪 Signature Cookies (Add 4 more)
    [
        'name' => 'Pistachio Cranberry Shortbread',
        'category' => 'Signature Cookies',
        'price' => 88000,
        'stock' => 20,
        'description' => 'Shortbread mentega renyah dengan cincangan kacang pistachio gurih dan kismis cranberry manis.',
        'image' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Triple Choc Brownie Cookies',
        'category' => 'Signature Cookies',
        'price' => 82000,
        'stock' => 25,
        'description' => 'Fudge cookies kenyal lembut dengan 3 kombinasi coklat hitam, coklat susu, dan coklat putih.',
        'image' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&q=80&w=800'
    ]
];

$added = 0;
foreach ($megaProducts as $pData) {
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

echo "=== MEGA SEEDING SUMMARY ===\n";
echo "New products added: {$added}\n";
echo "Total products in database: " . Product::count() . "\n";

foreach (Category::all() as $c) {
    echo "Category: {$c->name} (Slug: {$c->slug}) -> " . $c->products()->count() . " products\n";
}
