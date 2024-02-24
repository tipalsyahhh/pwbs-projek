@extends('layout.master')

@section('judul')
Tambah Produk
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .card-pemesanan{
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgb(0 0 0 / 49%);
        padding: 10px;
        font-weight: bold;
    }

    .card-pemesanan h3{
        margin-top: 10px;
        margin-bottom: 40px;
        color: #2eada7;
        font-weight: bold;
    }

    .form-group-product {
        margin-bottom: 20px;
    }

    #counter {
        font-size: 16px;
        display: inline-block;
        margin-left: auto;
        width: 50px;
        border: 1px solid #333;
        border-radius: 5px;
    }

    .card-pesan{
        width: 100%;
        height: auto;
        display: flex;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .image-pesan{
        width: 50%;
        padding: 10px;
    }

    .detail-pesan{
        width: 50%;
        margin-left: 5px;
        padding: 10px;
        color: #333;
    }

    .button-pesan{
        border: none;
        width: 40px;
        background-color: #2eada7;
        border-radius: 5px;
        color: #fff;
        font-weight: bold;
    }
</style>

@section('content')
@php
use Illuminate\Support\Facades\Auth;
@endphp
@section('content')
@php
$user = Auth::user();
@endphp

@if ($user)
@if ($user->role !== 'admin' && !App\Models\DataAkun::where('user_id', $user->id)->exists())
@php
header('Location: ' . route('dataAkun.create'));
exit();
@endphp
@endif
@else
@endif

<div class="card-pemesanan">
    <center><h3>Novsosiaplaze</h3></center>
    <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label style="color: #333;">Yang anda pesan</label>
            <input type="text" class="form-control" value="{{ $postingan->nama_menu }}" readonly style="background-color: #fff;">
            <input type="hidden" name="menu_id" value="{{ $postingan->id }}">
        </div>

        @error('menu_id')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="card-pesan">
            <div class="image-pesan">
                @if ($postingan->image)
                @php
                $imagePaths = explode(',', $postingan->image);
                $firstImagePath = trim($imagePaths[0]);
                @endphp
                <img src="{{ asset($firstImagePath) }}" alt="Gambar Postingan" style="width: 100%;">
                @else
                <p>Tidak ada gambar yang tersedia.</p>
                @endif
            </div>
            <div class="detail-pesan">
                <p>{{$postingan->user->datatoko->nama_depan}} {{$postingan->user->datatoko->nama_belakang}}</p>
                <p>{{$postingan->user->datatoko->alamat}}</p>
                <p id="harga">Rp {{ number_format($postingan->harga, 0, ',', '.') }}</p>
            </div>
        </div>

        <label style="color: #333;">Jumlah Beli</label>
        <div class="form-group-product">
                <button type="button" onclick="decrement()" class="button-pesan">-</button>
                <span id="counter"><center>0</center></span>
                <button type="button" onclick="increment()" class="button-pesan">+</button>
            <input type="hidden" name="jumlah_beli" id="jumlah_beli" value="0">
        </div>

        <div>
            <label style="color: #333;">Total Harga :</label>
            <span id="total">0</span>
        </div>

        @error('jumlah_beli')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn" style="background-color: #2eada7; color: white;"><i class="bi bi-save"></i>
            Pesan</button>
    </form>
</div>

<script>
    var counterValue = 0;
    var hargaSatuan = {{ $postingan-> harga }};

    function updateCounter() {
        document.getElementById("counter").innerHTML = counterValue;
        document.getElementById("jumlah_beli").value = counterValue;

        var totalHarga = counterValue * hargaSatuan;
        document.getElementById("total").innerHTML = formatNumber(totalHarga);
    }

    function decrement() {
        if (counterValue > 0) {
            counterValue--;
            updateCounter();
        }
    }

    function increment() {
        counterValue++;
        updateCounter();
    }

    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>
@endsection