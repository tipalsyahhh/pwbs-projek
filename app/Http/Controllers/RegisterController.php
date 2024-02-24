<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\Product;
use App\Models\Status;
use App\Models\Follow;
use App\Models\Likes;
use App\Models\Postingan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends BaseController
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'user' => 'required|unique:login',
            'nomor_handphone' => 'required',
            'password' => 'required',
            'namadepan' => 'required',
            'namabelakang' => 'required',
        ]);

        $user = $request->input('user');
        $nomor_handphone = $request->input('nomor_handphone');
        $password = $request->input('password');
        $namadepan = $request->input('namadepan');
        $namabelakang = $request->input('namabelakang');

        $remember_token = Str::random(60);

        $hashedPassword = Hash::make($password);

        $login = new Login([
            'user' => $user,
            'nomor_handphone' => $nomor_handphone,
            'password' => $hashedPassword,
            'namadepan' => $namadepan,
            'namabelakang' => $namabelakang,
            'remember_token' => $remember_token,
        ]);

        $login->save();

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk dengan akun Anda.');
    }

    public function edit($id, Request $request)
    {
        $user = Auth::user();
        $statuses = Status::all();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $postingan = Postingan::all();
        $firstname = $request->input('first_name');
        $lastname = $request->input('last_name');
        $login = Login::findOrFail($id);
        return view('user.edit', compact('login', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'postingan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user' => 'required|unique:login,user,' . $id,
            'nomor_handphone' => 'required',
            'namadepan' => 'required',
            'namabelakang' => 'required',
        ]);

        $user = $request->input('user');
        $nomor_handphone = $request->input('nomor_handphone');
        $namadepan = $request->input('namadepan');
        $namabelakang = $request->input('namabelakang');

        $login = Login::findOrFail($id);
        $login->update([
            'user' => $user,
            'nomor_handphone' => $nomor_handphone,
            'namadepan' => $namadepan,
            'namabelakang' => $namabelakang,
        ]);

        return redirect()->route('login')->with('success', 'Data berhasil diperbarui!');
    }

}