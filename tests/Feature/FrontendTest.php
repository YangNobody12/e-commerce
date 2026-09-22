<?php

namespace Tests\Feature;

use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);
    }

    public function test_home_page_can_be_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('ยินดีต้อนรับสู่ร้านค้าออนไลน์');
        $response->assertSee('เสื้อยืดแขนสั้น Cotton 100%');
        $response->assertSee('หมวดหมู่สินค้า');
    }

    public function test_shop_index_page_can_be_rendered(): void
    {
        $response = $this->get('/shop');
        $response->assertStatus(200);
        $response->assertSee('สินค้าทั้งหมด');
        $response->assertSee('เสื้อยืดแขนสั้น Cotton 100%');
        $response->assertSee('ประแจเลื่อน 8 นิ้ว ชุบโครเมียม');
    }

    public function test_shop_filter_by_category(): void
    {
        $response = $this->get('/shop?category=tools');
        $response->assertStatus(200);
        $response->assertSee('ประแจเลื่อน 8 นิ้ว ชุบโครเมียม');
        $response->assertDontSee('บะหมี่กึ่งสำเร็จรูป รสต้มยำกุ้ง');
    }

    public function test_shop_show_page_can_be_rendered(): void
    {
        $response = $this->get('/shop/cotton-t-shirt');
        $response->assertStatus(200);
        $response->assertSee('เสื้อยืดแขนสั้น Cotton 100%');
        $response->assertSee('350.00');
    }

    public function test_contact_page_can_be_rendered_and_shows_team_members(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('ติดต่อเรา');
        $response->assertSee('หยาง');
        $response->assertSee('พลับ');
        $response->assertSee('โชค');
        $response->assertSee('กวาง');
        $response->assertSee('ปิงปอง');
    }
}
