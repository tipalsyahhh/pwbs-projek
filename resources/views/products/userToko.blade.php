@extends('layout.master')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

<head>
    <link rel="stylesheet" href="{{ asset('desain/css/struk.css') }}">
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
    .foouter-postingan {
        width: 100%;
        height: 250px;
        padding: 10px;
        margin-top: 70px;
        background-image: url('../../img/contoh.gif');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .card-judul {
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.49);
        padding: 10px;
        margin-top: 100px;
        transform: translateY(-50%);
        background-color: #fff;
    }

    .card-judul h4 {
        font-weight: bold;
        color: #2eada7;
    }

    .user-postingan {
        display: flex;
        align-items: center;
        color: #333;
        margin-bottom: 10px;
    }

    .user-postingan img {
        width: 60px;
        height: 60px;
        border-radius: 50px;
        margin-right: 15px;
        object-fit: cover;
    }

    .card-pesan{
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.49);
        padding: 10px;
        margin-bottom: 35px;
        margin-top: -15px;
        color: #333;
        cursor: pointer;
    }

    .isi{
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    </style>
</head>

@section('content')
<div class="card-judul">
    <center>
        <h4>Pesanan Toko Mu</h4>
    </center>
    <div class="user-postingan">
        <img class="img-profile rounded-circle"
            src="{{ $user->profileImage ? asset('storage/' . $user->profileImage->image_path) : asset('storage/default_profile.png') }}">
        <div class="detail-produk">
            @foreach ($datatoko as $datatoko)
            @if (Auth::user()->role === 'admin' || $datatoko->user_id === Auth::user()->id)
            <p style="margin-bottom: 5px;">{{ auth()->user()->datatoko->nama_depan }} {{
                auth()->user()->datatoko->nama_belakang }}</p>
            <p style="margin-bottom: 5px">{{ auth()->user()->datatoko->alamat }}</p>
            @break
            @endif
            @endforeach

        </div>
    </div>
</div>
@php
    $products = $products->reverse();
@endphp
    @foreach ($products as $index => $product)
        @if ($product->postingan->user_id === Auth::user()->id)
            <div class="card-pesan" style="background-color: {{ $product->status === 'menunggu' ? 'rgba(173, 216, 230, 0.5)' : '#fff' }}" data-toggle="modal" data-target="#myModal{{ $index }}">
                <div class="isi">
                <img src="{{ optional($product->user->profileImage)->image_path ? asset('storage/' . $product->user->profileImage->image_path) : asset('storage/default_profile.png') }}"
                    alt="Profile Image" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                    <p style="margin-left: 10px; margin-bottom: 5px;">{{ $product->login->user }}</p>
                    @if ($product->status === 'menunggu')
                        <p style="margin-left: 10px; margin-bottom: 5px; margin-left: auto; font-weight: bold;">Pesanan baru</p>
                    @endif
                </div>
                <div class="isi-pesanan">
                    <p style="margin-bottom: 2px;">Nama product : {{ $product->postingan->nama_menu }}</p>
                    <p style="margin-bottom: 2px;">Jumlah pesanan : {{ $product->jumlah_beli }} pcs</p>
                    <p style="margin-bottom: 2px;">Status pesanan : {{ $product->status }}</p>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" style="color: #333; font-weight: bold;">Detail Pesanan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="color: #333;">
                            <p style="margin-bottom: 2px;">Nama product : {{ $product->postingan->nama_menu }}</p>
                            <p style="margin-bottom: 2px;">Di pesan oleh : {{ $product->login->user }}</p>
                            <p style="margin-bottom: 2px;">Alamat : {{ $product->alamat->alamat }}</p>
                            <p style="margin-bottom: 2px;">Jumlah pesan : {{ $product->jumlah_beli }} pcs</p>
                            <p style="margin-bottom: 2px;">Total Pembayaran : Rp {{ number_format($product->total_harga, 0, ',', '.') }}</p>
                            <p style="margin-bottom: 2px;">Waktu pesan : {{ $product->created_at }}</p>
                            <p style="margin-bottom: 2px;">Status pesanan : {{ $product->status }}</p>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex">
                                <form method="POST" action="{{ route('approve.order') }}" class="mr-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn" style="background-color: #2eada7; color: #fff;"><i class="bi bi-check-all"></i></button>
                                </form>
                            
                                <form action="{{ route('products.rejectOrder') }}" method="POST" class="mr-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn" style="background-color: #2eada7; color: #fff;"><i class="bi bi-x-circle"></i></button>
                                </form>
                            
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background-color: #2eada7; color: #fff;"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
