<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Postingan;
use App\Models\Product;
use App\Models\Follow;
use App\Models\Likes;
use App\Models\Keranjang;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PagesController extends BaseController
{
    //
    public function frominput(){
        return view('from_input');
    }

    public function Welcome(Request $request){
        $products = Product::all();
        $postingan = Postingan::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
    
        // Mendapatkan nilai rata-rata untuk setiap postingan
        $averageRatings = DB::table('rating')
        ->whereIn('menu_id', $postingan->pluck('id'))
        ->groupBy('menu_id')
        ->select('menu_id', DB::raw('SUM(rating) as totalRating'), DB::raw('COUNT(rating) as countRating'))
        ->get();
    
    $averageRatingsMap = $averageRatings->pluck('totalRating', 'menu_id')->toArray();
    $countsMap = $averageRatings->pluck('countRating', 'menu_id')->toArray();
    
    // Hitung nilai rata-rata
    $averageRatingMap = [];
    foreach ($postingan as $post) {
        $menuId = $post->id;
        $totalRating = $averageRatingsMap[$menuId] ?? 0;
        $countRating = $countsMap[$menuId] ?? 0;
    
        $averageRating = $countRating > 0 ? $totalRating / $countRating : 0;
        $averageRatingMap[$menuId] = $averageRating;
    }
    
        $jumlahBeliPerProduk = [];
        foreach ($products as $product) {
            $postinganProduk = $product->postingan;
            $jumlahBeliPerProduk[$product->id] = $postinganProduk ? $postinganProduk->jumlah_beli : 0;
        }
    
        return view('pages.welcome', compact('postingan', 'firstname', 'lastname', 'products', 'follows', 'likes', 'keranjang', 'jumlahBeliPerProduk', 'averageRatings', 'averageRatingMap'));
    }
    
    public function notifikasi(Request $request){
        $user = Auth::user();
        $products = Product::all();
        $postingan = Postingan::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];

        return view('pages.notif', compact('postingan', 'firstname', 'lastname', 'products', 'user', 'follows', 'likes', 'keranjang'));
    }

    public function kedu(Request $request){
        $user = Auth::user();
        $products = Product::all();
        $postingan = Postingan::all();

        return view('userAdmin.adminHome', compact('postingan', 'user', 'products'));
    }
}
