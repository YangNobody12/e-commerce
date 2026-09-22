<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate([
            'slug' => 'clothes',
        ], [
            'name' => 'เสื้อผ้า',
            'description' => 'เสื้อผ้าแฟชั่น',
        ]);

        Product::firstOrCreate(
            ['slug' => 'sample-shirt'],
            [
                'category_id' => $category->id,
                'name' => 'เสื้อเชิ้ตตัวอย่าง',
                'description' => 'เสื้อเชิ้ตคุณภาพดีสำหรับทุกวัน',
                'price' => 450.00,
                'stock' => 20,
                'image' => null,
                'is_active' => true,
            ]
        );
    }
}
