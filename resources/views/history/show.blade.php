@extends('layout.master')

<head>
    <link rel="stylesheet" href="{{ asset('desain/css/struk.css') }}">
</head>
@section('content')
<div class="card-struk">
    <center>
        <div class="centang">
            <i class="bi bi-check-lg" style="font-size: 1.7em;"></i>
        </div>
        <h4>Pemesanan Berhasil</h4>
        <p style="margin-top: -5px;">Status pesanan anda {{$product->status}}</p>
        <p style="margin-top: -5px;">Pemesan :</p>
        <p style="margin-top: -15px;">{{$user->user}}</p>
        <h2>Rp {{ number_format($product->total_harga, 0, ',', '.') }}</h2>
    </center>
    <h5>Detail Transaksi</h5>
    <div class="detail-struk">
        <p>Nama Toko :</p>
        <p>
            {{ optional($product->postingan->user->datatoko)->nama_depan }}
            {{ optional($product->postingan->user->datatoko)->nama_belakang }}
        </p>
    </div>
    <div class="detail-struk">
        <p>Nama Product :</p>
        <p>
            {{$product->postingan->nama_menu}}
        </p>
    </div>
    <div class="detail-struk">
        <p>Harga Peritem :</p>
        <p>
            Rp {{ number_format($product->postingan->harga, 0, ',', '.') }}
        </p>
    </div>
    <div class="detail-struk">
        <p>Jumlah Pesan :</p>
        <p>
            {{$product->jumlah_beli}}
        </p>
    </div>
    <div class="detail-struk">
        <p>Waktu Pesan :</p>
        <p>
            {{$product->created_at}}
        </p>
    </div>
    <div class="detail-struk" style="color: #2eada7; font-weight: bold;">
        <h5 style="font-weight: bold;">Total Harga :</h5>
        <h5 style="font-weight: bold;">
            Rp {{ number_format($product->total_harga, 0, ',', '.') }}
        </h5>
    </div>
</div>
<div class="struk-button">
    <a href="{{ route('history.index') }}" style="text-decoration: none;">Kembali</a>
</div>
@endsection