<?php

namespace App\Http\Controllers;

use App\Services\ProductData;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $allProducts = ProductData::all();
        $categories = ProductData::categories();

        $selectedCategory = $request->query('category');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $sort = $request->query('sort', 'latest');

        $products = array_filter($allProducts, function ($p) use ($selectedCategory, $minPrice, $maxPrice) {
            if ($selectedCategory && $p['category_slug'] !== $selectedCategory && $p['category'] !== $selectedCategory) {
                return false;
            }
            if ($minPrice !== null && $minPrice !== '' && $p['price'] < floatval($minPrice)) {
                return false;
            }
            if ($maxPrice !== null && $maxPrice !== '' && $p['price'] > floatval($maxPrice)) {
                return false;
            }
            return true;
        });

        // Re-index
        $products = array_values($products);

        // Sorting
        if ($sort === 'price_asc') {
            usort($products, fn($a, $b) => $a['price'] <=> $b['price']);
        } elseif ($sort === 'price_desc') {
            usort($products, fn($a, $b) => $b['price'] <=> $a['price']);
        } elseif ($sort === 'name') {
            usort($products, fn($a, $b) => strcmp($a['name'], $b['name']));
        }

        return view('shop.index', compact('products', 'categories', 'selectedCategory', 'minPrice', 'maxPrice', 'sort'));
    }

    public function show($slug)
    {
        $product = ProductData::findBySlug($slug);
        if (!$product) {
            abort(404);
        }

        return view('shop.show', compact('product'));
    }
}
