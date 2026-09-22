<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'เสื้อผ้าและแฟชั่น',
                'slug' => 'fashion',
                'description' => 'เสื้อผ้าและแฟชั่นทันสมัย',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'name' => 'ของใช้ในบ้าน',
                'slug' => 'household',
                'description' => 'ของใช้จำเป็นภายในบ้าน',
                'image' => 'https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'name' => 'สุขภาพและความงาม',
                'slug' => 'beauty',
                'description' => 'ผลิตภัณฑ์ดูแลสุขภาพและความงาม',
                'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'name' => 'อาหารและเครื่องดื่ม',
                'slug' => 'food',
                'description' => 'อาหารสำเร็จรูปและเครื่องดื่ม',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'name' => 'เครื่องใช้ในบ้านและครัว',
                'slug' => 'kitchen',
                'description' => 'เครื่องใช้ในบ้านและอุปกรณ์ครัว',
                'image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'name' => 'เครื่องมือช่างและอุปกรณ์',
                'slug' => 'tools',
                'description' => 'เครื่องมือช่างและอุปกรณ์ปรับปรุงบ้าน',
                'image' => 'https://images.unsplash.com/photo-1581147036324-c17ac41dfa6c?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'name' => 'เครื่องใช้ไฟฟ้าและแกดเจ็ต',
                'slug' => 'gadgets',
                'description' => 'อุปกรณ์อิเล็กทรอนิกส์และแกดเจ็ต',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=60',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
