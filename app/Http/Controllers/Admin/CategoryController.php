<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $data = $request->only(['name', 'description']);
        $baseSlug = Str::slug($request->name) ?: 'category-' . time();
        $slug = $baseSlug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            try {
                $dir = public_path('images/categories');
                if (!is_dir($dir)) {
                    @mkdir($dir, 0775, true);
                }
                $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
                $request->image->move($dir, $imageName);
                $data['image'] = 'images/categories/' . $imageName;
            } catch (\Throwable $e) {
                Log::error('Category image store error: ' . $e->getMessage());
                return back()->withInput()->with('error', 'ไม่สามารถอัปโหลดรูปภาพได้: ' . $e->getMessage());
            }
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'เพิ่มหมวดหมู่สำเร็จ!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $data = $request->only(['name', 'description']);
        $baseSlug = Str::slug($request->name) ?: 'category-' . time();
        $slug = $baseSlug;
        $counter = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            try {
                if ($category->image && !str_starts_with($category->image, 'http') && is_file(public_path($category->image))) {
                    @unlink(public_path($category->image));
                }

                $dir = public_path('images/categories');
                if (!is_dir($dir)) {
                    @mkdir($dir, 0775, true);
                }
                $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
                $request->image->move($dir, $imageName);
                $data['image'] = 'images/categories/' . $imageName;
            } catch (\Throwable $e) {
                Log::error('Category image update error: ' . $e->getMessage());
                return back()->withInput()->with('error', 'ไม่สามารถอัปโหลดรูปภาพได้: ' . $e->getMessage());
            }
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'แก้ไขหมวดหมู่สำเร็จ!');
    }

    public function destroy(Category $category)
    {
        if ($category->image && !str_starts_with($category->image, 'http') && is_file(public_path($category->image))) {
            @unlink(public_path($category->image));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'ลบหมวดหมู่สำเร็จ!');
    }
}
