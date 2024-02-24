<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\Login;
use App\Models\DataAkun;
use App\Notifications\FriendshipAccepted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user(); // Mendapatkan pengguna yang saat ini masuk
    
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $friendUsers  = Login::where('id', '!=', $user->id)->get(); // Mendapatkan daftar teman
    
        return view('friends.index', compact('friendUsers', 'firstname', 'lastname', 'user'));
    }    
    
    public function sendRequest(Request $request)
    {
        // Validasi bahwa user yang akan ditambahkan sebagai teman tersedia
        $friendId = $request->input('friend_id');
        $user = Auth::user();

        // Cek apakah user yang akan ditambahkan sebagai teman ada
        $friend = Login::find($friendId);

        if (!$friend) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Cek apakah permintaan pertemanan sudah ada
        $friendshipExists = Friendship::where([
            'user_id' => $user->id,
            'friend_id' => $friendId,
        ])->first();

        if ($friendshipExists) {
            return redirect()->back()->with('error', 'Anda sudah mengirimkan permintaan pertemanan sebelumnya.');
        }

        // Buat permintaan pertemanan
        $friendship = new Friendship();
        $friendship->user_id = $user->id;
        $friendship->friend_id = $friendId;
        $friendship->status = Friendship::PENDING;
        $friendship->save();

        return redirect()->back()->with('success', 'Permintaan pertemanan berhasil dikirim.');
    }

    public function acceptFriendRequest(Request $request)
    {
        $user = auth()->user(); // Mengambil data pengguna yang sedang masuk
    
        // Pastikan parameter sesuai dengan kolom basis data
        $friendship = Friendship::where('user_id', $request->user_id) // user_id adalah ID pengguna yang mengirim permintaan pertemanan
            ->where('friend_id', $user->id) // friend_id adalah ID pengguna yang sedang masuk
            ->where('status', Friendship::PENDING)
            ->first();
    
        if (!$friendship) {
            return redirect()->back()->with('error', 'Tidak ada permintaan pertemanan yang dapat diterima.');
        }
    
        // Terima permintaan pertemanan
        $friendship->status = Friendship::ACCEPTED;
        $friendship->save();
    
        return redirect()->back()->with('success', 'Anda telah menerima permintaan pertemanan.');
    }  

    public function rejectRequest(Request $request)
    {
        $user = auth()->user(); // Mengambil data pengguna yang sedang masuk
    
        // Pastikan parameter sesuai dengan kolom basis data
        $friendship = Friendship::where('user_id', $request->user_id) // user_id adalah ID pengguna yang mengirim permintaan pertemanan
            ->where('friend_id', $user->id) // friend_id adalah ID pengguna yang sedang masuk
            ->where('status', Friendship::PENDING)
            ->first();
    
        if (!$friendship) {
            return redirect()->back()->with('error', 'Tidak ada permintaan pertemanan yang dapat ditolak.');
        }
    
        // Tolak permintaan pertemanan
        $friendship->status = Friendship::REJECTED;
        $friendship->save();
    
        return redirect()->back()->with('success', 'Anda telah menolak permintaan pertemanan.');
    }

    public function show(Request $request)
    {
        $user = Auth::user(); // Mendapatkan pengguna yang saat ini masuk
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        
        // Ubah cara Anda mendapatkan daftar permintaan pertemanan yang masuk
        $friendRequests = Friendship::where('friend_id', $user->id)
            ->where('status', Friendship::PENDING)
            ->get();
        
        return view('friends.show', compact('friendRequests', 'firstname', 'lastname', 'user'));
    }   
    
    public function listFriends(Request $request)
    {
        $user = auth()->user(); // Mendapatkan pengguna yang saat ini masuk
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
    
        // Ambil daftar teman-teman yang memiliki status ACCEPTED
        $friendsSent = Friendship::where('user_id', $user->id)
            ->where('status', Friendship::ACCEPTED)
            ->with('friend') // Eager load data teman
            ->get();
    
        // Ambil daftar teman-teman yang mengajukan pertemanan kepada pengguna saat ini dan telah diterima
        $friendsReceived = Friendship::where('friend_id', $user->id)
            ->where('status', Friendship::ACCEPTED)
            ->with('user') // Eager load data teman
            ->get();
    
        // Gabungkan dan hapus duplikat daftar teman
        $friends = $friendsSent->concat($friendsReceived)->unique();
    
        return view('friends.list', compact('friends', 'firstname', 'lastname', 'user'));
    }

    public function showProfile($userId, Request $request)
    {
        $user = auth()->user();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        
        // Ambil data profil dari model DataAkun beserta relasi profileImage
        $userProfile = DataAkun::with('user.profileImage')->where('user_id', $userId)->first();
        
        if (!$userProfile) {
            // Handle the case when the user profile is not found
            return redirect()->route('friends.index')->with('error', 'User profile not found.');
        }
        
        return view('friends.profile', compact('userProfile', 'firstname', 'lastname', 'user'));
    }  
}