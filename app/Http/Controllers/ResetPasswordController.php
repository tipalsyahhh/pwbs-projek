<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Follow;
use App\Models\Likes;
use App\Models\Keranjang;
use App\Models\Postingan;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends BaseController
{
    public function showResetForm($username, Request $request)
    {
        $products = Product::all();
        $user = Auth::user();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        return view('akun.reset-password-form', ['username' => $username], compact('firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang', 'postingan'));
    }

    public function resetPassword(Request $request)
    {
        $user = Auth::user();
        $products = Product::all();
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus masuk terlebih dahulu.');
        }
    
        if (!Hash::check($request->input('old_password'), $user->password)) {
            return redirect()->back()->with('error', 'Password lama tidak valid.');
        }
    
        $user->password = Hash::make($request->input('password'));
    
        try {
            $user->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan password. Silahkan coba lagi.');
        }
    
        $username = $user->username;
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
    
        session()->flash('success', 'Password berhasil diubah. Silahkan login dengan password baru.');
    
        return view('akun.reset-password-form', compact('username', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang', 'postingan'));
    }
    
}
