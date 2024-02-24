<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomentarEven;
use Illuminate\Support\Facades\Auth;

class KomentarEvenController extends Controller
{
    public function index()
    {
        // Menampilkan daftar komentar
        $komentars = KomentarEven::all();
        return view('komentars.index', compact('komentars'));
    }

    public function create()
    {
        // Menampilkan formulir untuk membuat komentar baru
        return view('even.tampilanEven');
    }

    public function store(Request $request)
    {
        // Memperoleh ID pengguna yang sedang login
        $user_id = auth()->user()->id;

        // Menyimpan komentar baru ke dalam database dengan user_id yang sudah diisi
        KomentarEven::create([
            'user_id' =>  $user_id ,
            'komentar' => $request->input('komentar'),
            // tambahkan kolom lainnya sesuai kebutuhan
        ]);

        // Redirect kembali ke view even.tampilanEven
        return back();
    }

    public function show($id)
    {
        // Menampilkan detail komentar berdasarkan ID
        $komentar = KomentarEven::findOrFail($id);
        return view('komentars.show', compact('komentar'));
    }

    public function edit($id)
    {
        // Menampilkan formulir untuk mengedit komentar berdasarkan ID
        $komentar = KomentarEven::findOrFail($id);
        return view('komentars.edit', compact('komentar'));
    }

    public function update(Request $request, $id)
    {
        // Memperbarui komentar berdasarkan ID
        $komentar = KomentarEven::findOrFail($id);
        $komentar->update($request->all());
        return redirect()->route('komentars.index');
    }

    public function destroy($id)
    {
        // Menghapus komentar berdasarkan ID
        $komentar = KomentarEven::findOrFail($id);
        $komentar->delete();
        return redirect()->route('komentars.index');
    }
}
