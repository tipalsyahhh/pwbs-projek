<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Follow;
use App\Models\likes;
use App\Models\Keranjang;
use App\Models\Postingan;

class RatingController extends Controller
{
    public function create(Request $request, $postinganId = null)
    {
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::find($postinganId);

        if (!$postingan) {
            return redirect()->route('error')->with('error', 'Postingan tidak ditemukan.');
        }
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
    
        return view('rating.create', compact('firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang', 'postingan'));
    }
    
    public function store(Request $request)
    {
        
        $request->validate([
            'menu_id' => 'required|exists:postingan,id',
            'rating' => 'required|integer|between:1,5',
            'comentar' => 'required',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user_id = auth()->user()->id;
    
        $postingan = Postingan::find($request->menu_id);

        $imagePaths = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('storage/images'), $imageName);

                $imagePaths[] = 'storage/images/' . $imageName;
            }
        }
    
        $rating = Rating::create([
            'user_id' => $user_id,
            'menu_id' => $postingan->id,
            'rating' => $request->rating,
            'comentar' => $request->comentar,
            'image' => implode(',', $imagePaths),
        ]);
    
        $rating->save();
        
    
        return redirect()->route('detailProduct', ['id' => $postingan->id])
            ->with('success', 'Rating berhasil ditambahkan');
    } 

    public function show($id, Request $request)
    {
        $postingan = Postingan::find($id);
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $user = Auth::user();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];

        return view('rating.comen', compact('postingan', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang'));
    }
    
}
