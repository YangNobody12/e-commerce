<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();

        $selectedCategory = $request->query('category');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $sort = $request->query('sort', 'latest');

        $query = Product::with('category')->where('is_active', true);

        if ($selectedCategory) {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory)
                  ->orWhere('name', $selectedCategory);
            });
        }

        if ($minPrice !== null && $minPrice !== '') {
            $query->where('price', '>=', floatval($minPrice));
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('price', '<=', floatval($maxPrice));
        }

        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(9)->withQueryString();

        return view('shop.index', compact(
            'products',
            'categories',
            'selectedCategory',
            'minPrice',
            'maxPrice',
            'sort'
        ));
    }

    public function show($slug)
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('shop.show', compact('product'));
    }
}
