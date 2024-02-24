<?php

namespace App\Http\Controllers;

use App\Models\DataAkun;
use App\Models\Keranjang;
use App\Models\Postingan;
use App\Models\Product;
use App\Models\Follow;
use App\Models\Likes;
use App\Models\DataToko;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    
    public function index(Request $request)
    {
        $userId = Auth::id();

        $keranjangItems = Keranjang::with('postingan')->where('user_id', auth()->user()->id)->get();
        $keranjang = Keranjang::all();

        $postingan = Postingan::all();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $dataakun = DataAkun::all();

        $user = Auth::user();
        $userItem = DataToko::find($userId);
        $firstname = $user->first_name;
        $lastname = $user->last_name;

        return view('keranjang.index', compact('keranjangItems', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'postingan', 'userItem', 'keranjang'));
    }

    public function tambahItem($id, Request $request)
    {
        $request->validate([
        ]);
    
        $userId = auth()->user()->id;
        $postinganId = $id;
        $postingan = Postingan::findOrFail($postinganId);
    
        Keranjang::create([
            'user_id' => $userId,
            'menu_id' => $postinganId,
        ]);

        return redirect()->route('detailProduct', ['id' => $postingan->id])->with('success', 'Item berhasil ditambahkan ke dalam keranjang.');
    }    
       
    public function destroy($id)
    {
        $keranjangItem = Keranjang::find($id);

        if (!$keranjangItem) {
            return redirect()->route('keranjang.index')->with('error', 'Item keranjang tidak ditemukan.');
        }
        $keranjangItem->delete();

        return redirect()->route('keranjang.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

}
