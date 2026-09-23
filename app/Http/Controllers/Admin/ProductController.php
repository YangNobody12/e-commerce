<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'price', 'stock']);
        $baseSlug = Str::slug($request->name) ?: 'product-' . time();
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                $dir = public_path('images/products');
                if (!is_dir($dir)) {
                    @mkdir($dir, 0775, true);
                }
                $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
                $request->image->move($dir, $imageName);
                $data['image'] = 'images/products/' . $imageName;
            } catch (\Throwable $e) {
                Log::error('Product image store error: ' . $e->getMessage());
                return back()->withInput()->with('error', 'ไม่สามารถอัปโหลดรูปภาพได้: ' . $e->getMessage());
            }
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'เพิ่มสินค้าสำเร็จ!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'price', 'stock']);
        $baseSlug = Str::slug($request->name) ?: 'product-' . time();
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                if ($product->image && !str_starts_with($product->image, 'http') && is_file(public_path($product->image))) {
                    @unlink(public_path($product->image));
                }

                $dir = public_path('images/products');
                if (!is_dir($dir)) {
                    @mkdir($dir, 0775, true);
                }
                $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
                $request->image->move($dir, $imageName);
                $data['image'] = 'images/products/' . $imageName;
            } catch (\Throwable $e) {
                Log::error('Product image update error: ' . $e->getMessage());
                return back()->withInput()->with('error', 'ไม่สามารถอัปโหลดรูปภาพได้: ' . $e->getMessage());
            }
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'แก้ไขสินค้าสำเร็จ!');
    }

    public function destroy(Product $product)
    {
        if ($product->image && !str_starts_with($product->image, 'http') && is_file(public_path($product->image))) {
            @unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'ลบสินค้าสำเร็จ!');
    }
}
