<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

$categories = Category::all()->keyBy('name');
echo "Categories found: " . $categories->keys()->implode(', ') . "\n";

$newProducts = [
    // Roti Manis
    [
        'name' => 'Roti Abon Sapi Roll',
        'category' => 'Roti Manis',
        'price' => 18000,
        'stock' => 25,
        'description' => 'Roti gulung lembut dengan isian mayones manis gurih dan taburan abon sapi melimpah.',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Roti Keju Manis Spesial',
        'category' => 'Roti Manis',
        'price' => 16000,
        'stock' => 30,
        'description' => 'Roti manis dengan taburan keju cheddar parut tebal dan krim mentega lembut di dalamnya.',
        'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Roti Coklat Lumer Klasik',
        'category' => 'Roti Manis',
        'price' => 15000,
        'stock' => 20,
        'description' => 'Roti manis empuk dengan isian coklat belgia melimpah yang meleleh saat disantap hangat.',
        'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800'
    ],

    // Roti Tawar
    [
        'name' => 'Roti Tawar Gandum Utuh',
        'category' => 'Roti Tawar',
        'price' => 32000,
        'stock' => 18,
        'description' => 'Roti tawar gandum kaya serat dan nutrisi, tanpa pengawet buatan, sangat cocok untuk sarapan sehat.',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Roti Tawar Brioche Perancis',
        'category' => 'Roti Tawar',
        'price' => 42000,
        'stock' => 12,
        'description' => 'Roti tawar khas Perancis dengan kandungan mentega murni kaya rasa yang sangat harum dan wangi.',
        'image' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800'
    ],

    // French Pastries / Kue & Pastry
    [
        'name' => 'Pain au Chocolat Belgia',
        'category' => 'French Pastries',
        'price' => 28000,
        'stock' => 22,
        'description' => 'Pastry Perancis renyah dengan berlapis-lapis mentega dan isian batang coklat belgia murni.',
        'image' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Almond Croissant Panggang',
        'category' => 'French Pastries',
        'price' => 32000,
        'stock' => 15,
        'description' => 'Croissant renyah dengan isian krim frangipane almond dan taburan irisan kacang almond panggang.',
        'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Danish Strawberry Cream',
        'category' => 'French Pastries',
        'price' => 30000,
        'stock' => 14,
        'description' => 'Pastry Danish renyah dengan krim vanila Perancis dan buah strawberry segar di atasnya.',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
    ],

    // Artisan Bread
    [
        'name' => 'French Baguette Klasik',
        'category' => 'Artisan Bread',
        'price' => 28000,
        'stock' => 16,
        'description' => 'Roti Perancis panjang dengan kulit renyah garing dan bagian dalam yang lembut berpori sempurna.',
        'image' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Rosemary Herb Ciabatta',
        'category' => 'Artisan Bread',
        'price' => 35000,
        'stock' => 10,
        'description' => 'Roti tradisional Italia dengan aroma daun rosemary segar dan miyak zaitun extra virgin berkualitas.',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
    ],

    // Premium Cakes
    [
        'name' => 'Matcha Opera Cake',
        'category' => 'Premium Cakes',
        'price' => 280000,
        'stock' => 6,
        'description' => 'Kue lapis Perancis bermutu tinggi dengan keharuman Matcha Uji Jepang asli dan krim coklat lezat.',
        'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Classic New York Cheesecake',
        'category' => 'Premium Cakes',
        'price' => 310000,
        'stock' => 8,
        'description' => 'Cheesecake panggang khas New York yang padat, kaya rasa keju krim, dan meleleh di mulut.',
        'image' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Mango Coconut Mousse Cake',
        'category' => 'Premium Cakes',
        'price' => 295000,
        'stock' => 5,
        'description' => 'Kue mousse buah mangga arumanis segar dengan lapisan kelapa gurih yang menyegarkan.',
        'image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&q=80&w=800'
    ],

    // Signature Cookies
    [
        'name' => 'Belgian Chocolate Chip Cookies',
        'category' => 'Signature Cookies',
        'price' => 75000,
        'stock' => 25,
        'description' => 'Kue kering renyah di luar dan lembut di dalam dengan lelehan coklat chip belgia murni.',
        'image' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Matcha White Choc Cookies',
        'category' => 'Signature Cookies',
        'price' => 80000,
        'stock' => 20,
        'description' => 'Cookies rasa hijau matcha Jepang dipadukan dengan potongan coklat putih berkualitas tinggi.',
        'image' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Butter Shortbread Cookies',
        'category' => 'Signature Cookies',
        'price' => 70000,
        'stock' => 30,
        'description' => 'Cookies mentega tradisional Skotlandia kaya rasa yang lumer langsung saat disantap bersama teh.',
        'image' => 'https://images.unsplash.com/photo-1590080875515-8a3a8dc5735e?auto=format&fit=crop&q=80&w=800'
    ]
];

$added = 0;
foreach ($newProducts as $pData) {
    $cat = $categories->get($pData['category']);
    if (!$cat) {
        // Find by partial or create
        $cat = Category::firstOrCreate(
            ['name' => $pData['category']],
            ['slug' => Str::slug($pData['category'])]
        );
    }

    $slug = Str::slug($pData['name']);
    
    // Check if exists
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
        echo "Added product: {$pData['name']} ({$pData['category']})\n";
    }
}

echo "Done! Total new products added: {$added}\n";
echo "Total products in database: " . Product::count() . "\n";
