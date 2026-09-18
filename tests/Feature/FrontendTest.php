<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontendTest extends TestCase
{
    public function test_home_page_can_be_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('ยินดีต้อนรับสู่ร้านค้าออนไลน์');
    }

    public function test_shop_index_page_can_be_rendered(): void
    {
        $response = $this->get('/shop');
        $response->assertStatus(200);
        $response->assertSee('สินค้าทั้งหมด');
    }

    public function test_shop_show_page_can_be_rendered(): void
    {
        $response = $this->get('/shop/sample-slug');
        $response->assertStatus(200);
        $response->assertSee('ชื่อสินค้า');
    }
}
