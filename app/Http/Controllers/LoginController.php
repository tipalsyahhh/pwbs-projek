<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Login;

class LoginController extends BaseController
{
    public function showLoginForm()
    {
        return view('login');
    }
    
    public function authenticate(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'password' => 'required',
        ]);
    
        $user = $request->input('user');
        $inputPassword = $request->input('password');
    
        $userModel = Login::where('user', $user)->first();
    
        if (!$userModel) {
            return redirect()->back()->with('error', 'Nama pengguna tidak ditemukan.');
        }
    
        if (Hash::check($inputPassword, $userModel->password)) {
            Auth::login($userModel);
            if ($userModel->role === 'admin') {
                return redirect()->route('userAdmin.adminHome');
            } else {
                return redirect()->route('like.status');
            }
        } else {
            return redirect()->back()->with('error', 'Password salah.');
        }
    }           

    public function userChart()
    {
        $monthlySales = Login::selectRaw('MONTH(created_at) as month, COUNT(DISTINCT user) as total_users')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    
        return response()->json($monthlySales);
    }
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
