<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Follow;
use App\Models\Likes;
use App\Models\Keranjang;
use App\Models\Postingan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
        $user = $request->user();
        $products = Product::where('user_id', $user->id)->get();

        $products = Product::all();
        return view('history.index', compact('products', 'firstname', 'lastname', 'user', 'follows', 'likes', 'keranjang', 'postingan'));
    }

    public function show($id, Request $request)
    {
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $product = Product::find($id);
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
        return view('history.show', compact('product', 'products', 'firstname', 'lastname', 'user', 'follows', 'likes', 'keranjang', 'postingan'));
    }
}