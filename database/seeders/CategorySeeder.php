<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'เสื้อผ้า', 'slug' => 'clothes', 'description' => 'เสื้อผ้าแฟชั่น'],
            ['name' => 'รองเท้า', 'slug' => 'shoes', 'description' => 'รองเท้าแบรนด์'],
            ['name' => 'กระเป๋า', 'slug' => 'bags', 'description' => 'กระเป๋าแฟชั่น'],
            ['name' => 'เครื่องประดับ', 'slug' => 'accessories', 'description' => 'เครื่องประดับต่างๆ'],
            ['name' => 'อิเล็กทรอนิกส์', 'slug' => 'electronics', 'description' => 'อุปกรณ์อิเล็กทรอนิกส์'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
