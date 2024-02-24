<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Likes;
use App\Models\Login;
use App\Models\Status;
use App\Models\Product;
use App\Models\Follow;
use App\Models\Keranjang;
use App\Models\Postingan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
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

        $statuses = Status::all(); 

        $likedStatuses = Status::whereHas('likes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        $commentedStatuses = Likes::whereNotNull('comentar')->get();

        return view('like.status', [
            'statuses' => $statuses,
            'likedStatuses' => $likedStatuses,
            'commentedStatuses' => $commentedStatuses,
        ], compact('firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'statuses', 'keranjang', 'postingan'));
    }

    public function addLike($status_id)
    {
        $user_id = Auth::user()->id;

        $status = Status::find($status_id);

        if ($status_id) {
            $existingLike = Likes::where('user_id', $user_id)
                ->where('status_id', $status->id)
                ->where('like', 1)
                ->whereNull('comentar')
                ->get();
        
            if ($existingLike->isNotEmpty()) {
                foreach ($existingLike as $like) {
                    $like->delete();
                }
            } else {
                $like = new Likes();
                $like->user_id = $user_id;
                $like->status_id = $status->id;
                $like->like = 1;
                $like->notifikasi = 'belum dibaca';
                $like->save();
            }
        
            $status->loadCount('likes');
            $likesCount = $status->likes_count;
        
            return redirect()->route('status.show', ['status_id' => $status->id])
                ->with(['success' => 'Like berhasil ditambahkan.', 'likesCount' => $likesCount]);
        } else {
            return redirect()->back()->with('error', 'Status tidak ditemukan.');
        }        
    }

    public function addComment(Request $request, $status_id)
    {
        $user_id = auth()->user()->id;
        $commentText = $request->input('comment');

        $comment = new Likes();
        $comment->user_id = $user_id;
        $comment->comentar = $commentText;
        $comment->notifikasi = 'belum dibaca';

        $status = Status::find($status_id);
        $comment->status()->associate($status);

        $comment->save();


        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }


    public function showComments($status_id, Request $request)
    {
        $user = auth()->user();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $status = Status::findOrFail($status_id);
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();

        $comments = Likes::where('status_id', $status_id)->where('comentar', '!=', null)->get();

        return view('like.comments', compact('comments', 'user', 'status', 'firstname', 'lastname', 'products', 'follows', 'likes', 'keranjang', 'postingan'));
    }

    public function show($status_id)
    {
        $status = Status::find($status_id);
        $statuses = Status::all();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $postingan = Postingan::all();

        if (!$status) {
            abort(404);
        }

        $likesCount = $status->likes_count;

        $commentsCount = $status->comments->count();

        return view('like.status', [
            'statuses' => $statuses,
            'products' => $products,
            'follows' => $follows,
            'likes' => $likes,
            'status' => $status,
            'postingan' => $postingan,
            'likesCount' => $likesCount,
            'commentsCount' => $commentsCount,
        ]);
    }

    public function resetNotificationCount3(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'status_id*' => 'required|exists:status,id',
        ]);
    
        $statusId = intval($request->status_id);
    
        $affectedRows = Likes::whereHas('status', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('notifikasi', 'belum dibaca')
            ->update([
                'notifikasi' => 'sudah dibaca',
                
            ]);
    
        return redirect()->route('pages.notif')
            ->with(compact('user'))
            ->with('success', "Notifikasi 'sudah dibaca' untuk $affectedRows rekaman dengan status_id $statusId milik pengguna yang login");
    }
    
}
