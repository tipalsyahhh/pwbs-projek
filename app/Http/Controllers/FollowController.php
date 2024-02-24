<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\Login;
use App\Models\DataAkun;
use App\Models\Status;
use App\Models\Product;
use App\Models\Likes;
use App\Models\Keranjang;
use App\Models\Postingan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
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
        $postingan = Postingan::all();
        $allUsers = Login::where('id', '!=', auth()->user()->id)->get();

        return view('follow.index', compact('allUsers', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang', 'postingan'));
    }

    public function follow(Request $request, $userId)
    {
        $user = Login::find($userId);
    
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
        }
    
        $follow = new Follow();
        $follow->user_id = auth()->user()->id;
        $follow->following_user_id = $userId;
        $follow->notifikasi = 'belum dibaca';
        $follow->created_at = now();

        $follow->save();
    
        $follows = Follow::where('user_id', auth()->user()->id)->get();
    
        return redirect()->back()->with('success', 'Anda berhasil mengikuti pengguna ' . $user->user);
    }
    

    public function unfollow(Request $request, $userId)
    {
        $user = Login::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
        }

        auth()->user()->following()->detach($userId);

        return redirect()->back()->with('success', 'Anda berhenti mengikuti pengguna ' . $user->user);
    }

    public function followers($userId)
    {
        $user = Login::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
        }

        $followers = $user->followers;

        return view('followers', compact('user', 'followers'));
    }

    public function following($userId)
    {
        $user = Login::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
        }

        $following = $user->following;

        return view('following', compact('user', 'following'));
    }

    public function showProfile($userId, Request $request)
    {
        $user = auth()->user();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();
        $statusCount = Status::where('user_id', $userId)->count();
        
        $userProfile = DataAkun::with('user.profileImage', 'user.followers', 'user.myStatuses')->where('user_id', $userId)->first();
        $users = Login::withCount(['followers', 'following'])->get();
        $userItem = Login::find($userId);
        
        if (!$userProfile) {
            return redirect()->route('follow.index')->with('error', 'User profile not found.');
        }
        
        return view('follow.profile', compact('userProfile', 'firstname', 'lastname', 'user', 'userItem', 'products', 'statusCount', 'follows', 'likes', 'keranjang', 'postingan'));
    } 

    public function resetNotificationCount2(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'follows_id*' => 'required|exists:follows,id',
        ]);
    
        $followsId = intval($request->follows_id);
    
        $affectedRows = Follow::where('following_user_id', $user->id)
            ->where('notifikasi', 'belum dibaca')
            ->update([
                'notifikasi' => 'sudah dibaca',
            ]);
    
        return redirect()->route('pages.notif')
            ->with(compact('user'))
            ->with('success', "Notifikasi 'sudah dibaca' untuk $affectedRows rekaman dengan status_id $followsId milik pengguna yang login");
    }
}
