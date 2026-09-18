<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // TODO: ดึงสินค้าแนะนำ & หมวดหมู่จาก database
        // ตอนนี้ใช้ข้อมูลจำลองก่อน
        return view('home');
    }
}
