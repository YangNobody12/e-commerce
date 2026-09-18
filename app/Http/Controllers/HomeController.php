<?php

namespace App\Http\Controllers;

use App\Services\ProductData;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = ProductData::categories();
        $products = ProductData::all();
        $featuredProducts = array_slice($products, 0, 4);

        return view('home', compact('categories', 'featuredProducts'));
    }
}
