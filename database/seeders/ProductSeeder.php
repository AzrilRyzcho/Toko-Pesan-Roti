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
        $rotiManis = Category::where('slug', 'roti-manis')->first();
        $rotiTawar = Category::where('slug', 'roti-tawar')->first();
        $kuePastry = Category::where('slug', 'kue-pastry')->first();

        $products = [
            [
                'category_id' => $kuePastry->id ?? 1,
                'name' => 'Croissant Butter Klasik',
                'description' => 'Croissant mentega ala Perancis yang renyah berlipat di luar, sangat lembut dan bersarang di dalam.',
                'price' => 25000.00,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=600',
                'is_available' => true
            ],
            [
                'category_id' => $rotiTawar->id ?? 1,
                'name' => 'Roti Tawar Susu Premium',
                'description' => 'Roti tawar ekstra lembut dipanggang dengan susu segar pilihan tanpa pengawet.',
                'price' => 35000.00,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=600',
                'is_available' => true
            ],
            [
                'category_id' => $rotiManis->id ?? 1,
                'name' => 'Roti Kopi Mentega',
                'description' => 'Roti beraroma kopi renyah khas dengan isian mentega gurih manis yang meleleh.',
                'price' => 15000.00,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=600',
                'is_available' => true
            ],
            [
                'category_id' => $kuePastry->id ?? 1,
                'name' => 'Pain au Chocolat',
                'description' => 'Pastry mentega lipat dengan isian cokelat hitam Perancis melimpah di setiap gigitan.',
                'price' => 28000.00,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1608198093002-ad4e005484ec?auto=format&fit=crop&q=80&w=600',
                'is_available' => true
            ]
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(
                ['slug' => Str::slug($prod['name'])],
                [
                    'category_id' => $prod['category_id'],
                    'name' => $prod['name'],
                    'description' => $prod['description'],
                    'price' => $prod['price'],
                    'stock' => $prod['stock'],
                    'image' => $prod['image'],
                    'is_available' => $prod['is_available']
                ]
            );
        }
    }
}
