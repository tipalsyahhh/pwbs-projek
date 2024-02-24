<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Login;
use App\Models\Product;
use App\Models\Likes;
use App\Models\Follow;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $statuses = Status::all();
        $statuses = Status::with('user')->get();
        $user = Auth::user();
        $products = Product::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        return view('statuses.index', compact('statuses', 'firstname', 'lastname', 'user', 'products'));
    }    

    public function create(Request $request)
    {
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        return view('statuses.create', compact('firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
    
        $user_id = auth()->user()->id;
    
        $imagePaths = [];
    
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = 'storage/images/' . $imageName;
                $image->move(public_path('storage/images'), $imageName);
    
                $imagePaths[] = $imagePath;
            }
        }
    
        Status::create([
            'user_id' => $user_id,
            'caption' => $request->caption,
            'image' => implode(',', $imagePaths),
        ]);
    
        return redirect()->route('dataAkun.index');
    }
     
    
    public function show($status_id)
    {
        $status = Status::find($status_id);
        $statuses = Status::all();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();

        if (!$status) {
            abort(404);
        }

        $status = Status::with('comments')->find($status_id);

        $likesCount = $status->likes->count();

        $commentsCount = $status->comments->count();

        return view('like.status', [
            'statuses' => $statuses,
            'products' => $products,
            'follows' => $follows,
            'likes' => $likes,
            'status' => $status,
            'likesCount' => $likesCount,
            'commentsCount' => $commentsCount,
        ]);
    }
    

    public function edit(Status $status, Request $request)
    {
        $user = Auth::user();
        $products = Product::all();
        $follows = Follow::all();
        $likes = Likes::all();
        $keranjang = Keranjang::all();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        return view('statuses.edit', compact('status', 'firstname', 'lastname', 'user', 'products', 'follows', 'likes', 'keranjang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);
    
        $status = Status::find($id);
    
        if (!$status) {
            return redirect()->route('statuses.index')->with('error', 'Status tidak ditemukan');
        }
    
        $redirectRoute = (Auth::user()->role == 'admin') ? 'statuses.index' : 'dataAkun.index';
        
        $imagePaths = [];
    
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                if ($status->image) {
                    $oldImage = pathinfo($status->image)['basename'];
                    Storage::disk('public')->delete('images/' . $oldImage);
                }
    
                $imageName = time() . '_' . $image->getClientOriginalName();
    
                $image->move(public_path('storage/images'), $imageName);
    
                $imagePaths[] = 'storage/images/' . $imageName;
            }
        } else {
            $imagePaths = explode(',', $status->image);
        }
    
        $status->update([
            'caption' => $request->caption,
            'image' => implode(',', $imagePaths),
        ]);
    
        return redirect()->route($redirectRoute)->with('success', 'Status berhasil diperbarui');
    }    

    public function showComments($status_id, Request $request)
    {
        $user = Auth::user();
        $firstname = $request['first_name'];
        $lastname = $request['last_name'];
        $follows = Follow::all();
        
        $status = Status::findOrFail($status_id);
        
        $likes = Likes::where('status_id', $status_id)->get();
    
        return view('like.comments', compact('likes', 'firstname', 'lastname', 'user', 'status', 'follows'));
    }
    public function destroy($id)
    {
        try {
            $status = Status::find($id);

            $status->likes()->delete();

            $status->delete();

            return redirect()->route('statuses.index')->with('success', 'Status berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('statuses.index')->with('error', 'Gagal menghapus status. Silakan coba lagi.');
        }
    }

    public function deleteProfile($id)
    {
        $status = Status::find($id);

        $status->likes()->delete();

        $status->delete();

        return redirect()->route('dataAkun.index')->with('success', 'Status berhasil dihapus');
    }

    public function getStatusCountByUser()
    {
        $userId = Auth::id();

        $statusCount = Status::where('user_id', $userId)->count();

        return view('status.count', compact('statusCount'));
    }
}
