<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'slug' => 'cotton-t-shirt',
                'name' => 'เสื้อยืดแขนสั้น Cotton 100%',
                'category_slug' => 'fashion',
                'price' => 350.00,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=500&auto=format&fit=crop&q=60',
                'description' => 'เสื้อยืดแขนสั้นผลิตจากผ้า Cotton 100% สวมใส่สบาย ระบายอากาศได้ดี ดีไซน์มินิมอลเหมาะสำหรับทุกวัน',
                'is_active' => true,
            ],
            [
                'slug' => 'detergent-concentrated-1000g',
                'name' => 'ผงซักฟอก สูตรเข้มข้น 1,000g',
                'category_slug' => 'household',
                'price' => 129.00,
                'stock' => 80,
                'image' => 'https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=500&auto=format&fit=crop&q=60',
                'description' => 'ผงซักฟอกสูตรเข้มข้น ขจัดคราบฝังลึกได้หมดจด กลิ่นหอมสะอาดสดชื่นยาวนาน ถนอมเส้นใยผ้า',
                'is_active' => true,
            ],
            [
                'slug' => 'anti-dandruff-shampoo-450ml',
                'name' => 'แชมพูสูตรขจัดรังแค 450ml',
                'category_slug' => 'beauty',
                'price' => 159.00,
                'stock' => 45,
                'image' => 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?w=500&auto=format&fit=crop&q=60',
                'description' => 'แชมพูสูตรพิเศษช่วยขจัดรังแคอย่างมีประสิทธิภาพ บำรุงหนังศีรษะให้ชุ่มชื้น ลดอาการคัน ผมนุ่มสลวย',
                'is_active' => true,
            ],
            [
                'slug' => 'facial-tissue-3pack',
                'name' => 'กระดาษทิชชู่ เช็ดหน้า (แพ็ค 3 ห่อ)',
                'category_slug' => 'household',
                'price' => 79.00,
                'stock' => 120,
                'image' => 'https://images.unsplash.com/photo-1584556812952-905ffd0c611a?w=500&auto=format&fit=crop&q=60',
                'description' => 'กระดาษเช็ดหน้าเนื้อเนียนนุ่มพิเศษ ซึมซับดีเยี่ยม ไม่เป็นขุย ไร้สารเรืองแสง อ่อนโยนต่อทุกสภาพผิว',
                'is_active' => true,
            ],
            [
                'slug' => 'instant-noodle-tomyum-10pack',
                'name' => 'บะหมี่กึ่งสำเร็จรูป รสต้มยำกุ้ง (แพ็ค 10)',
                'category_slug' => 'food',
                'price' => 68.00,
                'stock' => 150,
                'image' => 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=500&auto=format&fit=crop&q=60',
                'description' => 'บะหมี่กึ่งสำเร็จรูป รสต้มยำกุ้งน้ำข้น เส้นเหนียวนุ่ม ซุปเข้มข้นถึงเครื่องต้มยำแท้ๆ อร่อยจุใจแพ็ค 10 ซอง',
                'is_active' => true,
            ],
            [
                'slug' => 'stainless-tumbler-30oz',
                'name' => 'แก้วน้ำเก็บความเย็น สแตนเลส 30 oz',
                'category_slug' => 'kitchen',
                'price' => 290.00,
                'stock' => 60,
                'image' => 'https://images.unsplash.com/photo-1577741314755-048d8525d31e?w=500&auto=format&fit=crop&q=60',
                'description' => 'แก้วเก็บความเย็น-ร้อน สแตนเลส 304 ขนาด 30 oz เก็บความเย็นได้นานถึง 18 ชั่วโมง ไม่มีหยดน้ำเกาะรอบแก้ว พกพาสะดวก',
                'is_active' => true,
            ],
            [
                'slug' => 'usb-rechargeable-flashlight',
                'name' => 'ไฟฉายแรงสูง ชาร์จ USB ได้',
                'category_slug' => 'tools',
                'price' => 180.00,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1546054454-aa26e2b734c7?w=500&auto=format&fit=crop&q=60',
                'description' => 'ไฟฉาย LED แรงสูง ส่องสว่างได้ไกล ปรับซูมได้ 5 โหมด แบตเตอรี่ในตัวชาร์จผ่านสาย USB น้ำหนักเบา ทนทาน กันละอองน้ำ',
                'is_active' => true,
            ],
            [
                'slug' => 'adjustable-wrench-8inch',
                'name' => 'ประแจเลื่อน 8 นิ้ว ชุบโครเมียม',
                'category_slug' => 'tools',
                'price' => 220.00,
                'stock' => 35,
                'image' => 'https://images.unsplash.com/photo-1581147036324-c17ac41dfa6c?w=500&auto=format&fit=crop&q=60',
                'description' => 'ประแจเลื่อนขนาด 8 นิ้ว ผลิตจากเหล็กกล้าคาร์บอนสูง ชุบโครเมียมป้องกันสนิม ปากประแจปรับระดับได้ลื่นไหล ไม่ติดขัด',
                'is_active' => true,
            ],
            [
                'slug' => 'utility-scissors-8inch',
                'name' => 'กรรไกรอเนกประสงค์ สแตนเลส 8 นิ้ว',
                'category_slug' => 'tools',
                'price' => 65.00,
                'stock' => 90,
                'image' => 'https://images.unsplash.com/photo-1508296695146-257a814070b4?w=500&auto=format&fit=crop&q=60',
                'description' => 'กรรไกรอเนกประสงค์ใบมีดสแตนเลส คมกริบ ด้ามจับหุ้มยางนุ่มกระชับมือ เหมาะสำหรับงานตัดทั่วไปในบ้านและที่ทำงาน',
                'is_active' => true,
            ],
            [
                'slug' => 'portable-bluetooth-speaker',
                'name' => 'ลำโพงบลูทูธพกพา เสียงเบสแน่น',
                'category_slug' => 'gadgets',
                'price' => 590.00,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500&auto=format&fit=crop&q=60',
                'description' => 'ลำโพงบลูทูธไร้สายขนาดกะทัดรัด พลังเสียงเกินตัว เบสแน่น แบตเตอรี่ใช้งานได้ต่อเนื่อง 8 ชั่วโมง รองรับ Bluetooth 5.3',
                'is_active' => true,
            ],
        ];

        foreach ($products as $p) {
            $category = Category::where('slug', $p['category_slug'])->first();
            if ($category) {
                Product::updateOrCreate(
                    ['slug' => $p['slug']],
                    [
                        'category_id' => $category->id,
                        'name' => $p['name'],
                        'price' => $p['price'],
                        'stock' => $p['stock'],
                        'image' => $p['image'],
                        'description' => $p['description'],
                        'is_active' => $p['is_active'],
                    ]
                );
            }
        }
    }
}
