<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Postingan;
use App\Models\Login;
use App\Models\DataAkun;
use App\Models\Follow;
use App\Models\Likes;
use App\Models\Keranjang;
use App\Models\DataToko;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::has('user')->get();

        if ($user && $user->role === 'admin') {
            $products = Product::all();
        } else {
            $latestIsNew = Product::where('user_id', $user->id)
                ->orderBy('is_new', 'desc')
                ->first();

            if ($latestIsNew) {
                $products = Product::where('user_id', $user->id)
                    ->where('is_new', $latestIsNew->is_new)
                    ->get();
            }
        }

        return view('products.index', compact('products', 'firstname', 'lastname', 'user', 'follows', 'likes', 'postingan', 'keranjang'));
    }

    public function tokoUser(Request $request)
    {
        $user = Auth::user();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
    
        $products = $user->products;
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::has('user')->get();
        $datatoko = DataToko::all();

    
        return view('products.userToko', compact('postingan', 'products', 'firstname', 'lastname', 'user', 'follows', 'likes', 'keranjang', 'datatoko'));
    }

    public function create(Request $request, $postinganId = null)
    {
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $positangan = Postingan::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];

        if (!$postinganId) {
            $postingan = Postingan::latest('id')->first();
        } else {
            $postingan = Postingan::find($postinganId);

            if (!$postingan) {
                return redirect()->route('error')->with('error', 'Postingan tidak ditemukan.');
            }
        }

        $menus = Postingan::all();

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'alamat_id' => 'required',
                'jumlah_beli' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $postingan = Postingan::find($request->input('menu_id'));
            if (!$postingan) {
                return redirect()->back()->with('error', 'Menu tidak ditemukan.');
            }
            $hargaCleaned = preg_replace('/[^0-9]/', '', $postingan->harga);
            $harga = floatval($hargaCleaned);

            $product = new Product;
            $product->user_id = $user->id;
            $product->alamat_id = $request->input('alamat_id');
            $product->jumlah_beli = $request->input('jumlah_beli');
            $product->total_harga = $harga * $request->input('jumlah_beli');
            $product->created_at = now();
            $product->status = 'menunggu';
            $product->notifikasi = 'belum dibaca';
            $product->is_new = true;
            $product->save();

            return redirect()->route('products.index');
        }

        return view('products.create', compact('firstname', 'lastname', 'user', 'menus', 'products', 'postingan', 'follows', 'likes', 'keranjang'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'menu_id' => 'required|exists:postingan,id',
            'jumlah_beli' => 'required|integer',
        ]);

        $user = Auth::user();
        $data['user_id'] = $user->id;

        $dataAkun = DataAkun::where('user_id', $user->id)->first();

        if ($dataAkun) {
            $data['alamat_id'] = $dataAkun->id;
        } else {
            return redirect()->route('error')->with('error', 'Data Akun tidak ditemukan');
        }

        $harga = Postingan::where('id', $data['menu_id'])->value('harga');

        $data['total_harga'] = $harga * $data['jumlah_beli'];

        $lastIsNew = Product::where('user_id', $user->id)->max('is_new');
        $data['is_new'] = $lastIsNew ? $lastIsNew + 1 : 1;

        $data['created_at'] = now();

        $data['status'] = 'menunggu';

        $data['notifikasi'] = 'belum dibaca';

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Pesanan berhasil di buat, tunggu toko memferivikasi pesanan anda.');
    }


    public function show($id, Request $request)
    {
        $product = Product::find($id);
        $products = Product::all();
        $user = Auth::user();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        return view('products.index', compact('product', 'firstname', 'lastname', 'user', 'products'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'menu_id' => 'required',
            'user_id' => 'required',
            'alamat' => 'required',
            'jumlah_beli' => 'required',
        ]);

        $product = Product::find($id);
        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('products.userToko')->with('success', 'Produk berhasil dihapus.');
    }

    public function tataTertib(Request $request)
    {
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        return view('products.peraturan', compact('firstname', 'lastname', 'user', 'products', 'follows', 'likes'));
    }

    public function approveOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,id',
        ]);
        Product::where('id', $request->product_id)->update(['status' => 'disetujui']);

        return redirect()->route('products.userToko')->with('success', 'Status berhasil diubah menjadi disetujui');
    }

    public function rejectOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,id',
        ]);

        Product::where('id', $request->product_id)->update(['status' => 'ditolak']);

        return redirect()->route('products.userToko')->with('success', 'Status berhasil diubah menjadi ditolak');
    }

    public function resetNotificationCount(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'product_id*' => 'required|exists:product,id',
        ]);

        $productId = intval($request->product_id);

        $affectedRows = Product::where('user_id', $user->id)
            ->where('notifikasi', 'belum dibaca')
            ->where('status', '!=', 'menunggu')
            ->update([
                'notifikasi' => 'sudah dibaca',
            ]);

        return redirect()->route('pages.notif')
            ->with(compact('user'))
            ->with('success', "Notifikasi 'sudah dibaca' untuk $affectedRows rekaman dengan status_id $productId milik pengguna yang login");
    }

    public function salesChart()
    {
        $monthlySales = Product::selectRaw('MONTH(created_at) as month, SUM(total_harga) as total_sales')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($monthlySales);
    }
}