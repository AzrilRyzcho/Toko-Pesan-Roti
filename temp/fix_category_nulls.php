<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

$categoryDetails = [
    'Donat & Bagel' => [
        'description' => 'Donat empuk beraneka rasa dan bagel khas New York dipanggang segar setiap hari.',
        'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&q=80&w=800'
    ],
    'Paket Gift & Hampers' => [
        'description' => 'Pilihan hampers dan kotak bingkisan roti istimewa untuk momen spesial dan hadiah terkasih.',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
    ],
    'Minuman & Kopi' => [
        'description' => 'Seduhan kopi arabika segar, matcha latte Uji, dan minuman pendamping roti terbaik.',
        'image' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&q=80&w=800'
    ],
    'Roti Gluten-Free' => [
        'description' => 'Pilihan roti sehat bebas gluten yang terbuat dari bahan-bahan gandum alami kaya serat.',
        'image' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800'
    ],
    'Bakes & Savory' => [
        'description' => 'Aneka sajian panggang gurih dengan keju lumer dan rempah lezat khas bakery.',
        'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800'
    ],
    'Artisan Bread' => [
        'description' => 'Roti buatan tangan dengan bahan organik berkualitas dan proses fermentasi alami.',
        'image' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800'
    ],
    'Premium Cakes' => [
        'description' => 'Kue mewah dengan rasa lezat dan dekorasi elegan untuk perayaan momen istimewa Anda.',
        'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800'
    ],
    'French Pastries' => [
        'description' => 'Pastry ala Perancis yang renyah dan lembut di dalam dengan mentega impor pilihan.',
        'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800'
    ],
    'Signature Cookies' => [
        'description' => 'Kue kering renyah dengan rasa mentega premium dan potongan coklat melimpah.',
        'image' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800'
    ],
    'Roti Manis' => [
        'description' => 'Berbagai pilihan roti manis lembut dengan isian lezat yang disukai seluruh keluarga.',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
    ],
    'Roti Tawar' => [
        'description' => 'Roti tawar lembut dan bernutrisi tinggi untuk sarapan sehat keluarga Anda setiap pagi.',
        'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
    ],
    'Kue & Pastry' => [
        'description' => 'Kue premium dan pastry mentega ala Perancis yang dipanggang segar setiap hari.',
        'image' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800'
    ]
];

$updated = 0;
foreach (Category::all() as $cat) {
    if (isset($categoryDetails[$cat->name])) {
        $cat->description = $categoryDetails[$cat->name]['description'];
        $cat->image = $categoryDetails[$cat->name]['image'];
        $cat->save();
        $updated++;
        echo "Updated Category ID {$cat->id}: {$cat->name} -> Description & Image populated!\n";
    }
}

echo "Done! Total categories updated: {$updated}\n";
