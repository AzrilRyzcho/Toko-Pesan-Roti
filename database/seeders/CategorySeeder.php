<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Roti Manis',
                'description' => 'Berbagai pilihan roti manis lembut dengan isian lezat.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=600'
            ],
            [
                'name' => 'Roti Tawar',
                'description' => 'Roti tawar lembut dan bernutrisi tinggi untuk sarapan keluarga.',
                'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=600'
            ],
            [
                'name' => 'Kue & Pastry',
                'description' => 'Kue premium dan pastry mentega ala Perancis yang renyah.',
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=600'
            ]
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'image' => $cat['image']
                ]
            );
        }
    }
}
