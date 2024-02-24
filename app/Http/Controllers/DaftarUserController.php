<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $logins = Login::where('id', '!=', $user->id)->get();
    
        return view('login.index', compact('logins', 'user'));
    }
    
}