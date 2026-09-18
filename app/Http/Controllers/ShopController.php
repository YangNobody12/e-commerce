<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // TODO: ดึงสินค้าจาก database พร้อม pagination & filter
        return view('shop.index');
    }

    public function show($slug)
    {
        // TODO: ดึงข้อมูลสินค้าจาก database
        return view('shop.show');
    }
}
