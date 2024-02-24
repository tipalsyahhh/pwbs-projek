<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use App\Models\Login; // Pastikan model yang sesuai telah diimpor

class BaseController extends Controller
{
    public function __construct()
    {
        // Mendapatkan user yang saat ini login
        $user = Auth::user();

        if ($user) {
            // Mengambil nilai reset_token dari user jika ada
            $token = $user->reset_token;
        } else {
            // Gunakan nilai default jika user tidak terotentikasi
            $token = 'contoh_nilai_token';
        }

        // Membagikan variabel $token ke seluruh tampilan
        view()->share('token', $token);
    }
}
