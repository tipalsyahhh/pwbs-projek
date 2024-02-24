<?php

namespace App\Http\Controllers;

use App\Models\DataToko;
use App\Models\DataAkun;
use App\Models\Postingan;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Status;
use App\Models\Follow;
use App\Models\Likes;
Use App\Models\Keranjang;
use App\Models\Login;
use Illuminate\Support\Facades\Auth;

class DataTokoController extends Controller
{
    public function showProfile2($userId, Request $request)
    { {
            $loggedInUser = Auth::user();

            $statuses = Status::all();
            $products = Product::all();
            $follows = Follow::all();
            $likes = Likes::all();
            $keranjang = Keranjang::all();
            $postingan = Postingan::all();

            $user = Login::find($userId);

            if ($user) {
                $postingan = $user->myPostingan;

                $userProfile = DataToko::with('user.myPostingan')
                    ->where('user_id', $user->id)
                    ->first();

                $firstname = $request->input('first_name');
                $lastname = $request->input('last_name');
                $dataAkun = DataAkun::where('user_id', $user->id)->get();
                $userProfile = DataAkun::with('user.profileImage', 'user.followers', 'user.myStatuses')->where('user_id', $user->id)->first();
                $statusCount = Postingan::where('user_id', $user->id)->count();

                $data = compact('dataAkun', 'userProfile', 'statusCount', 'postingan', 'firstname', 'lastname', 'loggedInUser', 'products', 'follows', 'likes', 'userProfile', 'keranjang');

                return view('datatoko.index', $data);
            } else {
                return redirect()->route('some_redirect_route')->with('error', 'User not found.');
            }
        }
    }

    public function show($dataTokoId)
    {
        $datatoko = DataToko::find($dataTokoId);
        $user = $datatoko->user;

        return view('datatoko.show', compact('datatoko', 'user'));
    }

    public function create($userId, Request $request)
    {
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        return view('datatoko.create', compact('firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang', 'postingan'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $datatoko = new DataToko([
            'nama_depan' => $request->input('nama_depan'),
            'nama_belakang' => $request->input('nama_belakang'),
            'alamat' => $request->input('alamat'),
            'email' => $request->input('email'),
            'detail' => $request->input('detail'),
            'user_id' => Auth::user()->id,
        ]);

        $datatoko->save();

        return redirect()->route('datatoko.index', ['userId' => Auth::user()->id]);
    }


    // Menampilkan data yang ingin diedit
    public function edit($user_id, Request $request)
    {
        $datatoko = dataToko::where('user_id', $user_id)->first();

        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $user = Auth::user();

        if (!$datatoko) {
            return redirect()->route('datatoko.index')->with('error', 'Data Akun tidak ditemukan');
        }

        return view('datatoko.edit', compact('datatoko', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang', 'postingan'));
    }

    public function update(Request $request)
    {
        // Mendapatkan pengguna yang sedang login
        $user = $request->user();

        // Menemukan atau membuat objek DataToko terkait dengan pengguna
        $datatoko = DataToko::firstOrNew(['user_id' => $user->id]);

        $request->validate([
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'detail' => 'required',
        ]);

        // Mengisi nilai-nilai atribut dari request
        $datatoko->nama_depan = $request->input('nama_depan');
        $datatoko->nama_belakang = $request->input('nama_belakang');
        $datatoko->alamat = $request->input('alamat');
        $datatoko->email = $request->input('email');
        $datatoko->detail = $request->input('detail');

        $datatoko->save();

        // Mendapatkan ID pengguna yang sedang login
        $userId = $user->id;

        return redirect()->route('datatoko.index', ['userId' => $userId])->with('success', 'Profil berhasil diperbarui');
    }

    // Menghapus data
    public function destroy($user_id)
    {
        $datatoko = DataToko::where('user_id', $user_id)->first();

        if ($datatoko) {
            $datatoko->delete();
            return redirect()->route('datatoko.index')->with('success', 'Data Profil berhasil dihapus');
        } else {
            return redirect()->route('datatoko.index')->with('error', 'Data Profil tidak ditemukan');
        }
    }

    protected function hasUserData($user)
    {
        return DataToko::where('user_id', $user->id)->exists();
    }
}
