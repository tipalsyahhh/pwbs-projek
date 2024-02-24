<?php

namespace App\Http\Controllers;

use App\Models\DataToko;
use Illuminate\Http\Request;
use App\Models\Postingan;
use App\Models\Product;
use App\Models\Follow;
use App\Models\likes;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;

class PostinganController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $datatoko = DataToko::all();

        $postingan = Postingan::all();
        $jumlahBeli = [];

        foreach ($postingan as $item) {
            $jumlahBeli[$item->id] = $item->products->sum('jumlah_beli');
        }

        return view('postingan.index', compact('postingan', 'jumlahBeli', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang', 'datatoko'));
    }

    public function umum(Request $request)
    {
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $datatoko = DataToko::all();

        $user_id = $user->id;
        $postingan = Postingan::where('user_id', $user_id)->get();
        $jumlahBeli = [];

        foreach ($postingan as $item) {
            $jumlahBeli[$item->id] = $item->products->sum('jumlah_beli');
        }

        return view('postingan.index', compact('postingan', 'jumlahBeli', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang', 'datatoko'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        return view('postingan.create', compact('firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|regex:/^\d+(\.\d{1,4})?/',
            'deskripsi' => 'required',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis' => 'required',
            'kapasitas' => 'required|integer',
        ]);


        $imagePaths = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('storage/images'), $imageName);

                $imagePaths[] = 'storage/images/' . $imageName;
            }
        }

        $user_id = auth()->user()->id;

        $postingan = new Postingan([
            'user_id' => $user_id,
            'nama_menu' => $request->get('nama_menu'),
            'harga' => $request->get('harga'),
            'deskripsi' => $request->get('deskripsi'),
            'image' => implode(',', $imagePaths),
            'jenis' => $request->get('jenis'),
            'kapasitas' => $request->get('kapasitas'),
        ]);

        $postingan->save();

        return redirect()->route('postingan.index')
            ->with('success', 'Postingan berhasil ditambahkan');
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

        $jumlahBeli = $postingan->products->sum('jumlah_beli');

        return view('postingan.detail', compact('postingan', 'jumlahBeli', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang'));
    }

    public function edit($id, Request $request)
    {
        $postingan = Postingan::find($id);
        $products = Product::all();
        $user = Auth::user();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        return view('postingan.edit', compact('postingan', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis' => 'required',
            'kapasitas' => 'integer',
        ]);

        $postingan = Postingan::find($id);

        if ($request->hasFile('image')) {
            $oldImagePaths = explode(',', $postingan->image);

            foreach ($oldImagePaths as $oldImagePath) {
                $oldImagePath = public_path($oldImagePath);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $imagePaths = [];

            foreach ($request->file('image') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = 'storage/images/' . $imageName;
                $image->move(public_path('storage/images'), $imageName);

                $imagePaths[] = $imagePath;
            }

            $postingan->update([
                'nama_menu' => $request->get('nama_menu'),
                'harga' => $request->get('harga'),
                'deskripsi' => $request->get('deskripsi'),
                'image' => implode(',', $imagePaths),
                'jenis' => $request->get('jenis'),
                'kapasitas' => $request->get('kapasitas'),
            ]);
        } else {
            $postingan->update([
                'nama_menu' => $request->get('nama_menu'),
                'harga' => $request->get('harga'),
                'deskripsi' => $request->get('deskripsi'),
                'jenis' => $request->get('jenis'),
                'kapasitas' => $request->get('kapasitas'),
            ]);
        }

        return redirect()->route('postingan.index')
            ->with('success', 'Postingan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $postingan = Postingan::find($id);

        $postingan->products()->delete();

        $postingan->delete();

        return redirect()->route('postingan.index')
            ->with('success', 'Postingan berhasil dihapus');
    }
}
