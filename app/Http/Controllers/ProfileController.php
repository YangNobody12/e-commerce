<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // แสดงหน้าโปรไฟล์
    public function show()
    {
        return view('profile.show', [
            'user' => auth()->user(),
        ]);
    }

    // แสดงฟอร์มแก้ไขโปรไฟล์
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    // อัพเดทโปรไฟล์
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('profile.show')
            ->with('success', 'อัพเดทโปรไฟล์สำเร็จ!');
    }

    // แสดงฟอร์มเปลี่ยนรหัสผ่าน
    public function editPassword()
    {
        return view('profile.password');
    }

    // อัพเดทรหัสผ่าน
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();

        // ตรวจสอบรหัสผ่านเก่า
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านเก่าไม่ถูกต้อง']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'เปลี่ยนรหัสผ่านสำเร็จ!');
    }
}