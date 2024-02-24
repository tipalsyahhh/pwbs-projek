<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataAkun;
use App\Models\Product;
use App\Models\Status;
use App\Models\Follow;
use App\Models\Likes;
use App\Models\postingan;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;

class DataAkunController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $statuses = Status::all();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $postingan = postingan::all();
        $keranjang = Keranjang::all();
        $firstname = $request->input('first_name');
        $lastname = $request->input('last_name');
        $dataAkun = DataAkun::where('user_id', $user->id)->get();
        $userProfile = DataAkun::with('user.profileImage', 'user.followers', 'user.myStatuses')->where('user_id', $user->id)->first();
        $statusCount = Status::where('user_id', $user->id)->count();
        $dataAkun = DataAkun::where('user_id', '=', $user->id)->get();
        $userProfile = DataAkun::with('user.profileImage', 'user.followers', 'user.myStatuses')
                        ->where('user_id', '=', $user->id)
                        ->first();
        $statusCount = Status::where('user_id', '=', $user->id)->count();
    
        return view('dataAkun.index', compact('dataAkun', 'firstname', 'lastname', 'user', 'userProfile', 'products', 'statuses', 'statusCount', 'follows', 'likes', 'postingan', 'keranjang'));
    }
    

    public function setting(Request $request)
    {
        $user = Auth::user();
        $statuses = Status::all();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
        $firstname = $request->input('first_name');
        $lastname = $request->input('last_name');
        $dataAkun = DataAkun::where('user_id', $user->id)->get();
        $userProfile = DataAkun::with('user.profileImage', 'user.followers', 'user.myStatuses')->where('user_id', $user->id)->first();
        $statusCount = Status::where('user_id', $user->id)->count();
    
        return view('dataAkun.setting', compact('dataAkun', 'firstname', 'lastname', 'user', 'userProfile', 'products', 'statuses', 'statusCount', 'follows', 'likes', 'postingan', 'keranjang'));
    }
    
    public function show($dataAkunId)
{
    $dataAkun = DataAkun::find($dataAkunId);
    $user = $dataAkun->user;

    return view('profile.show', compact('dataAkun', 'user'));
}

    public function create(Request $request)
    {
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $postingan = Postingan::all();
        $keranjang = Keranjang::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        return view('dataAkun.create', compact('firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'postingan', 'kerajang'));
    }

    public function store(Request $request)
    {
        $dataAkun = new DataAkun([
            'nama_depan' => $request->input('nama_depan'),
            'nama_belakang' => $request->input('nama_belakang'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'alamat' => $request->input('alamat'),
            'gender' => $request->input('gender'),
            'biodata' => $request->input('biodata'),
            'user_id' => Auth::user()->id,
        ]);
    
        $dataAkun->save();
    
        return redirect()->route('dataAkun.index');
    }   

    public function edit($user_id, Request $request)
    {
        $dataAkun = DataAkun::where('user_id', $user_id)->first();
    
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $user = Auth::user();
    
        if (!$dataAkun) {
            return redirect()->route('dataAkun.index')->with('error', 'Data Akun tidak ditemukan');
        }
    
        return view('dataAkun.edit', compact('dataAkun', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'postingan', 'keranjang'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $dataAkun = DataAkun::where('user_id', $user->id)->first();
    
        $request->validate([
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'biodata' => 'required',
        ]);
    
        if (!$dataAkun) {
            $dataAkun = new DataAkun();
            $dataAkun->user_id = $user->id;
        }
    
        $dataAkun->nama_depan = $request->input('nama_depan');
        $dataAkun->nama_belakang = $request->input('nama_belakang');
        $dataAkun->tanggal_lahir = $request->input('tanggal_lahir');
        $dataAkun->alamat = $request->input('alamat');
        $dataAkun->gender = $request->input('gender');
        $dataAkun->biodata = $request->input('biodata');
        $dataAkun->save();
    
        return redirect()->route('dataAkun.index')->with('success', 'Profil berhasil diperbarui');
    }    

    public function destroy($user_id)
    {
        $dataAkun = DataAkun::where('user_id', $user_id)->first();
    
        if ($dataAkun) {
            $dataAkun->delete();
            return redirect()->route('dataAkun.index')->with('success', 'Data Profil berhasil dihapus');
        } else {
            return redirect()->route('dataAkun.index')->with('error', 'Data Profil tidak ditemukan');
        }
    }

    protected function hasUserData($user)
    {
        return DataAkun::where('user_id', $user->id)->exists();
    }
}
