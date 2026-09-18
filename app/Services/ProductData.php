<?php

namespace App\Services;

class ProductData
{
    public static function all(): array
    {
        return [
            [
                'id' => 1,
                'slug' => 'cotton-t-shirt',
                'name' => 'เสื้อยืดแขนสั้น Cotton 100%',
                'category' => 'เสื้อผ้าและแฟชั่น',
                'category_slug' => 'fashion',
                'price' => 350.00,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=500&auto=format&fit=crop&q=60',
                'description' => 'เสื้อยืดแขนสั้นผลิตจากผ้า Cotton 100% สวมใส่สบาย ระบายอากาศได้ดี ดีไซน์มินิมอลเหมาะสำหรับทุกวัน',
            ],
            [
                'id' => 2,
                'slug' => 'detergent-concentrated-1000g',
                'name' => 'ผงซักฟอก สูตรเข้มข้น 1,000g',
                'category' => 'ของใช้ในบ้าน',
                'category_slug' => 'household',
                'price' => 129.00,
                'stock' => 80,
                'image' => 'https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=500&auto=format&fit=crop&q=60',
                'description' => 'ผงซักฟอกสูตรเข้มข้น ขจัดคราบฝังลึกได้หมดจด กลิ่นหอมสะอาดสดชื่นยาวนาน ถนอมเส้นใยผ้า',
            ],
            [
                'id' => 3,
                'slug' => 'anti-dandruff-shampoo-450ml',
                'name' => 'แชมพูสูตรขจัดรังแค 450ml',
                'category' => 'สุขภาพและความงาม',
                'category_slug' => 'beauty',
                'price' => 159.00,
                'stock' => 45,
                'image' => 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?w=500&auto=format&fit=crop&q=60',
                'description' => 'แชมพูสูตรพิเศษช่วยขจัดรังแคอย่างมีประสิทธิภาพ บำรุงหนังศีรษะให้ชุ่มชื้น ลดอาการคัน ผมนุ่มสลวย',
            ],
            [
                'id' => 4,
                'slug' => 'facial-tissue-3pack',
                'name' => 'กระดาษทิชชู่ เช็ดหน้า (แพ็ค 3 ห่อ)',
                'category' => 'ของใช้ในบ้าน',
                'category_slug' => 'household',
                'price' => 79.00,
                'stock' => 120,
                'image' => 'https://images.unsplash.com/photo-1584556812952-905ffd0c611a?w=500&auto=format&fit=crop&q=60',
                'description' => 'กระดาษเช็ดหน้าเนื้อเนียนนุ่มพิเศษ ซึมซับดีเยี่ยม ไม่เป็นขุย ไร้สารเรืองแสง อ่อนโยนต่อทุกสภาพผิว',
            ],
            [
                'id' => 5,
                'slug' => 'instant-noodle-tomyum-10pack',
                'name' => 'บะหมี่กึ่งสำเร็จรูป รสต้มยำกุ้ง (แพ็ค 10)',
                'category' => 'อาหารและเครื่องดื่ม',
                'category_slug' => 'food',
                'price' => 68.00,
                'stock' => 200,
                'image' => 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=500&auto=format&fit=crop&q=60',
                'description' => 'บะหมี่กึ่งสำเร็จรูปรสต้มยำกุ้งน้ำข้น รสชาติแซ่บเข้มข้นถึงเครื่องสมุนไพร เส้นเหนียวนุ่ม อิ่มอร่อยจุใจ',
            ],
            [
                'id' => 6,
                'slug' => 'tumbler-stainless-30oz',
                'name' => 'แก้วน้ำเก็บความเย็น สแตนเลส 30 oz',
                'category' => 'เครื่องใช้ในบ้านและครัว',
                'category_slug' => 'kitchen',
                'price' => 290.00,
                'stock' => 35,
                'image' => 'https://images.unsplash.com/photo-1577937927133-66ef06acdf18?w=500&auto=format&fit=crop&q=60',
                'description' => 'แก้วน้ำเก็บความเย็น-ร้อน สแตนเลสเกรด 304 หนา 2 ชั้น เก็บอุณหภูมิยาวนาน 12-24 ชั่วโมง ไร้หยดน้ำเกาะ',
            ],
            [
                'id' => 7,
                'slug' => 'high-power-flashlight-usb',
                'name' => 'ไฟฉายแรงสูง ชาร์จ USB ได้',
                'category' => 'เครื่องมือช่างและอุปกรณ์',
                'category_slug' => 'tools',
                'price' => 180.00,
                'stock' => 60,
                'image' => 'https://images.unsplash.com/photo-1550985543-f47f38aeee65?w=500&auto=format&fit=crop&q=60',
                'description' => 'ไฟฉาย LED ส่องสว่างสูง ส่องไกล ปรับซูมและโหมดไฟได้ 5 แบบ ตัวบอดี้อะลูมิเนียมกันน้ำ ชาร์จผ่านสาย USB',
            ],
            [
                'id' => 8,
                'slug' => 'adjustable-wrench-8inch',
                'name' => 'ประแจเลื่อน 8 นิ้ว ชุบโครเมียม',
                'category' => 'เครื่องมือช่างและอุปกรณ์',
                'category_slug' => 'tools',
                'price' => 220.00,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1581147036324-c17ac41dfa6c?w=500&auto=format&fit=crop&q=60',
                'description' => 'ประแจเลื่อนขนาด 8 นิ้ว หลอมจากเหล็กกล้าคาร์บอนสูง ชุบผิวโครเมียมกันสนิม ปรับขยายปากได้ลื่นไหลแข็งแรง',
            ],
            [
                'id' => 9,
                'slug' => 'utility-scissors-stainless-8inch',
                'name' => 'กรรไกรอเนกประสงค์ สแตนเลส 8 นิ้ว',
                'category' => 'เครื่องมือช่างและอุปกรณ์',
                'category_slug' => 'tools',
                'price' => 65.00,
                'stock' => 90,
                'image' => 'https://images.unsplash.com/photo-1590736969955-71cc94801759?w=500&auto=format&fit=crop&q=60',
                'description' => 'กรรไกรอเนกประสงค์สแตนเลสคมพิเศษ ด้ามจับยางออกแบบตามหลักสรีรศาสตร์ ตัดวัสดุได้หลากหลาย',
            ],
            [
                'id' => 10,
                'slug' => 'portable-bluetooth-speaker',
                'name' => 'ลำโพงบลูทูธพกพา เสียงเบสแน่น',
                'category' => 'เครื่องใช้ไฟฟ้าและแกดเจ็ต',
                'category_slug' => 'gadgets',
                'price' => 590.00,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500&auto=format&fit=crop&q=60',
                'description' => 'ลำโพงบลูทูธไร้สายพกพา ดอกลำโพงเบสคู่ทรงพลัง แบตเตอรี่อึดเล่นเพลงได้ต่อเนื่อง 10 ชั่วโมง กันละอองน้ำ IPX5',
            ],
        ];
    }

    public static function categories(): array
    {
        $all = self::all();
        $cats = [];

        $categoryImages = [
            'เสื้อผ้าและแฟชั่น' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=500&auto=format&fit=crop&q=60',
            'ของใช้ในบ้าน' => 'https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=500&auto=format&fit=crop&q=60',
            'สุขภาพและความงาม' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=500&auto=format&fit=crop&q=60',
            'อาหารและเครื่องดื่ม' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=500&auto=format&fit=crop&q=60',
            'เครื่องใช้ในบ้านและครัว' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?w=500&auto=format&fit=crop&q=60',
            'เครื่องมือช่างและอุปกรณ์' => 'https://images.unsplash.com/photo-1581147036324-c17ac41dfa6c?w=500&auto=format&fit=crop&q=60',
            'เครื่องใช้ไฟฟ้าและแกดเจ็ต' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=60',
        ];

        foreach ($all as $item) {
            $name = $item['category'];
            $slug = $item['category_slug'];
            if (!isset($cats[$name])) {
                $cats[$name] = [
                    'name' => $name,
                    'slug' => $slug,
                    'count' => 0,
                    'image' => $categoryImages[$name] ?? 'https://via.placeholder.com/400x200',
                ];
            }
            $cats[$name]['count']++;
        }

        return array_values($cats);
    }

    public static function findBySlug(string $slug): ?array
    {
        foreach (self::all() as $item) {
            if ($item['slug'] === $slug) {
                return $item;
            }
        }
        return self::all()[0] ?? null;
    }
}
