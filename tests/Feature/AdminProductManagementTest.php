<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_product_and_category_pages(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get('/admin/products')
            ->assertOk();

        $this->actingAs($admin)
            ->get('/admin/categories')
            ->assertOk();
    }

    public function test_admin_can_create_and_update_category_with_image(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $file = \Illuminate\Http\UploadedFile::fake()->image('category.png');

        $response = $this->actingAs($admin)->post('/admin/categories', [
            'name' => 'เครื่องแต่งกาย',
            'description' => 'หมวดหมู่เสื้อผ้าแฟชั่น',
            'image' => $file,
        ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'name' => 'เครื่องแต่งกาย',
        ]);

        $category = \App\Models\Category::where('name', 'เครื่องแต่งกาย')->first();
        $this->assertNotNull($category->image);
        $this->assertNotNull($category->image_url);

        // Update category with external or new image without error
        $newFile = \Illuminate\Http\UploadedFile::fake()->image('updated.webp');
        $updateResponse = $this->actingAs($admin)->put('/admin/categories/' . $category->id, [
            'name' => 'เครื่องแต่งกายชาย',
            'description' => 'อัปเดตแล้ว',
            'image' => $newFile,
        ]);

        $updateResponse->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'เครื่องแต่งกายชาย',
        ]);

        // Clean up uploaded test files from public directory if created
        $updatedCategory = $category->fresh();
        if ($category->image && file_exists(public_path($category->image))) {
            @unlink(public_path($category->image));
        }
        if ($updatedCategory->image && file_exists(public_path($updatedCategory->image))) {
            @unlink(public_path($updatedCategory->image));
        }
    }
}

