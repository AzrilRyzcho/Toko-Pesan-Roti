<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('name');

        $products = [
            // 🥐 Kue & Pastry
            [
                'name' => 'Croissant Butter Klasik',
                'category' => 'Kue & Pastry',
                'price' => 25000.00,
                'stock' => 25,
                'description' => 'Croissant mentega ala Perancis yang renyah berlipat di luar, sangat lembut dan bersarang di dalam.',
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=600'
            ],
            [
                'name' => 'Pain au Chocolat',
                'category' => 'Kue & Pastry',
                'price' => 28000.00,
                'stock' => 15,
                'description' => 'Pastry mentega lipat dengan isian cokelat hitam Perancis melimpah di setiap gigitan.',
                'image' => 'https://images.unsplash.com/photo-1608198093002-ad4e005484ec?auto=format&fit=crop&q=80&w=600'
            ],
            [
                'name' => 'Croissant Almond Butter Supreme',
                'category' => 'Kue & Pastry',
                'price' => 34000.00,
                'stock' => 20,
                'description' => 'Croissant mentega berlapis tebal dengan krim almond gurih dan taburan almond panggang renyah.',
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Pastry Cheese Roll Smoked Ham',
                'category' => 'Kue & Pastry',
                'price' => 29000.00,
                'stock' => 18,
                'description' => 'Puff pastry gulung dengan isian keju mozarella leleh dan potongan daging asap berkualitias.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Pistachio Cream Puff',
                'category' => 'Kue & Pastry',
                'price' => 26000.00,
                'stock' => 25,
                'description' => 'Kue sus Perancis dengan isian krim kacang pistachio asli dan parutan coklat putih di atasnya.',
                'image' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Danish Blueberry Cream Cheese',
                'category' => 'Kue & Pastry',
                'price' => 31000.00,
                'stock' => 15,
                'description' => 'Pastry Danish renyah bertabur blueberry segar dan krim keju melimpah yang manis gurih.',
                'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Chocolate Lava Croissant',
                'category' => 'Kue & Pastry',
                'price' => 33000.00,
                'stock' => 22,
                'description' => 'Croissant coklat hitam dengan isian lelehan coklat lava Belgia hangat yang melimpah.',
                'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=800'
            ],

            // 🍞 Roti Tawar
            [
                'name' => 'Roti Tawar Susu Premium',
                'category' => 'Roti Tawar',
                'price' => 35000.00,
                'stock' => 20,
                'description' => 'Roti tawar ekstra lembut dipanggang dengan susu segar pilihan tanpa pengawet.',
                'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=600'
            ],
            [
                'name' => 'Roti Tawar Kismis Cinnamon',
                'category' => 'Roti Tawar',
                'price' => 35000.00,
                'stock' => 20,
                'description' => 'Roti tawar lembut kaya akan buah kismis pilihan dan keharuman kayu manis yang menenangkan.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Roti Tawar Pandan Wangi',
                'category' => 'Roti Tawar',
                'price' => 30000.00,
                'stock' => 25,
                'description' => 'Roti tawar ekstra lembut dengan aroma alami sari daun pandan asli tanpa pewarna buatan.',
                'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Roti Tawar Multigrain Oats',
                'category' => 'Roti Tawar',
                'price' => 36000.00,
                'stock' => 18,
                'description' => 'Roti tawar gandum lengkap dengan taburan biji oat, flaxseed, dan biji wijen organik.',
                'image' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Roti Tawar Keju Marble',
                'category' => 'Roti Tawar',
                'price' => 39000.00,
                'stock' => 15,
                'description' => 'Roti tawar spesial dengan lelehan keju parut di dalam guratan marmer roti yang gurih.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
            ],

            // 🥖 Roti Manis
            [
                'name' => 'Roti Kopi Mentega',
                'category' => 'Roti Manis',
                'price' => 15000.00,
                'stock' => 30,
                'description' => 'Roti beraroma kopi renyah khas dengan isian mentega gurih manis yang meleleh.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=600'
            ],
            [
                'name' => 'Roti Polo Sweet Butter',
                'category' => 'Roti Manis',
                'price' => 17000.00,
                'stock' => 28,
                'description' => 'Roti manis dengan krust topping renyah manis beraroma mentega gurih ala Hong Kong.',
                'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Roti Sosis Keju Mozzarella',
                'category' => 'Roti Manis',
                'price' => 20000.00,
                'stock' => 22,
                'description' => 'Roti manis empuk berisi sosis sapi tebal dan lelehan keju mozzarella serta saus tomat spesial.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Roti Kelapa Gula Jawa',
                'category' => 'Roti Manis',
                'price' => 16000.00,
                'stock' => 30,
                'description' => 'Roti manis tradisional berisikan parutan kelapa muda dan gula merah aren murni yang legit.',
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Roti Kacang Merah Jepang (Anpan)',
                'category' => 'Roti Manis',
                'price' => 18000.00,
                'stock' => 24,
                'description' => 'Roti manis khas Jepang dengan isian pasta azuki kacang merah halus yang lembut dan manis alami.',
                'image' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&q=80&w=800'
            ],

            // 🥖 Artisan Bread
            [
                'name' => 'Cranberry Walnut Country Bread',
                'category' => 'Artisan Bread',
                'price' => 54000.00,
                'stock' => 12,
                'description' => 'Roti artisan pedesaan dengan asam manis kismis cranberry dan irisan kacang walnut panggang.',
                'image' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Garlic Butter Sourdough Batard',
                'category' => 'Artisan Bread',
                'price' => 48000.00,
                'stock' => 15,
                'description' => 'Roti sourdough asam alami yang diolesi mentega bawang putih dan peterseli harum.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800'
            ],

            // 🎂 Premium Cakes
            [
                'name' => 'Basque Burnt Cheesecake Premium',
                'category' => 'Premium Cakes',
                'price' => 320000.00,
                'stock' => 6,
                'description' => 'Cheesecake panggang khas Basque Spanyol dengan bagian atas gosong karamelized dan tengahnya yang creamy.',
                'image' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Earl Grey Lavender Sponge Cake',
                'category' => 'Premium Cakes',
                'price' => 290000.00,
                'stock' => 8,
                'description' => 'Kue spons ringan beraroma teh Earl Grey Perancis dan keharuman ekstrak bunga lavender.',
                'image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&q=80&w=800'
            ],

            // 🍪 Signature Cookies
            [
                'name' => 'Pistachio Cranberry Shortbread',
                'category' => 'Signature Cookies',
                'price' => 88000.00,
                'stock' => 20,
                'description' => 'Shortbread mentega renyah dengan cincangan kacang pistachio gurih dan kismis cranberry manis.',
                'image' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'name' => 'Triple Choc Brownie Cookies',
                'category' => 'Signature Cookies',
                'price' => 82000.00,
                'stock' => 25,
                'description' => 'Fudge cookies kenyal lembut dengan 3 kombinasi coklat hitam, coklat susu, dan coklat putih.',
                'image' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&q=80&w=800'
            ]
        ];

        foreach ($products as $prod) {
            $catName = $prod['category'];
            $cat = $categories->get($catName) ?: Category::where('name', $catName)->first();

            Product::updateOrCreate(
                ['slug' => Str::slug($prod['name'])],
                [
                    'category_id' => $cat ? $cat->id : 1,
                    'name' => $prod['name'],
                    'description' => $prod['description'],
                    'price' => $prod['price'],
                    'stock' => $prod['stock'],
                    'image' => $prod['image'],
                    'is_available' => true
                ]
            );
        }
    }
}
