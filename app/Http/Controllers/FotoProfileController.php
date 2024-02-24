<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\ProfileImage;
use App\Models\Product;
use App\Models\Follow;
use App\Models\Likes;
use App\Models\Keranjang;
use App\Models\Postingan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FotoProfileController extends BaseController
{
    public function index(Request $request)
    {
        $fotoProfiles = ProfileImage::all();
        $fotoProfiles = ProfileImage::where('user_id', Auth::user()->id)->get();
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        return view('fotoProfile.index', compact('fotoProfiles', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang', 'postingan'));
    }

    public function show($username)
    {
        $user = Login::where('user', $username)->first();
    
        if ($user) {
            return view('fotoProfile.create', compact('user'));
        } else {
            return redirect()->route('home')->with('error', 'Pengguna tidak ditemukan');
        }
    }
    
    public function showUploadForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return view('partial.nav', compact('user'));
        } else {
            return redirect()->route('home')->with('error', 'Anda harus login untuk mengunggah gambar profil.');
        }
    }

    public function showImage($imagePath)
    {
        $path = storage_path('app/public/' . $imagePath);
        return response()->file($path)->header('Content-Type', 'image/jpeg');
    }

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $imagePath = $request->file('image')->store('images', 'local');
    
        $user = Auth::user();
    
        if ($user) {
            $user->profileImage()->updateOrCreate([], ['image_path' => $imagePath]);
        }
    
        return redirect()->route('fotoProfile.index', ['username' => $user->user])->with('success', 'Gambar profil berhasil diunggah');
    }

    public function create()
    {
        $user = Auth::user(); 
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
        return view('fotoProfile.create', compact('user', 'products', 'follows', 'likes','keranjang', 'postingan'));
    }

    public function edit($user_id, Request $request)
    {
        $fotoProfile = ProfileImage::where('user_id', $user_id)->first();
    
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $user = Auth::user();
        if (!$fotoProfile) {
            return redirect()->route('foto-profile.index')->with('error', 'Foto Profile tidak ditemukan');
        }
    
        return view('fotoProfile.edit', compact('fotoProfile', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang', 'postingan'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profileImage = $user->profileImage;
    
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if (!$profileImage) {
            $profileImage = new ProfileImage();
            $profileImage->user_id = $user->id;
        }
    
        $profileImage->image_path = $request->file('image')->store('images', 'local');
        $profileImage->save();
    
        return redirect()->route('fotoProfile.index')->with('success', 'Foto profil berhasil diunggah');
    }

    public function destroy($user_id)
    {
        $fotoProfile = ProfileImage::where('user_id', $user_id)->first();

        if ($fotoProfile) {
            Storage::disk('local')->delete($fotoProfile->image_path);
            $fotoProfile->delete();

            return redirect()->route('fotoProfile.index')->with('success', 'Foto Profil berhasil dihapus');
        }

        return redirect()->route('fotoProfile.index')->with('error', 'Foto Profil tidak ditemukan');
    }
}
