@extends('layout.master')

@php
    use Illuminate\Support\Str;
@endphp

<link rel="stylesheet" href="{{ asset('desain/css/keranjang.css') }}">

@section('content')
<div class="judul-keranjang">
    <center>
        <h5>Keranjang Belanja {{ $user->user }}</h5>
        @if (auth()->user()->dataakun)
        <p><i class="bi bi-geo-alt-fill"></i> {{ auth()->user()->dataakun->alamat }}</p>
        @else
        <p>Data Akun tidak ditemukan</p>
        @endif
        <h6 style="margin-top: -10px; margin-bottom: 15px;">Novsosiaplaze</h6>
       <div class="btn-market">
        <a href="{{ route('pages.welcome') }}" style="text-decoration: none; color: #000;">Kembali</a>
       </div>
    </center>
</div>

@php
    $keranjangItems = $keranjangItems->reverse();
@endphp

<div class="keranjang">
    @if (count($keranjangItems) > 0)
    @foreach ($keranjangItems as $item)
    <div class="card-keranjang">
        <div class="nama-toko" style="display: flex; margin-bottom: 10px">
            @if($item->postingan && $item->postingan->user && $item->postingan->user->datatoko &&
            $item->postingan->user->datatoko->user_id)
            <a href="{{ route('datatoko.index', ['userId' => $item->postingan->user->datatoko->user_id]) }}" style="display: flex;">
                <img src="{{ optional($item->postingan->user->profileImage)->image_path ? asset('storage/' . $item->postingan->user->profileImage->image_path) : asset('storage/default_profile.png') }}"
                    alt="Profile Image" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                <p style="margin-left: 8px; color: #333;">{{ optional($item->postingan->user->datatoko)->nama_depan }} {{
                    optional($item->postingan->user->datatoko)->nama_belakang }}</p>
            </a>
            <i class="bi bi-chevron-compact-right" style="color: black; margin-top: 5px; margin-left: 5px;"></i>
            @endif
        </div>
        <div class="isi-keranjang">
            @if ($item->postingan && $item->postingan->image)
                @php
                    $imagePaths = explode(',', $item->postingan->image);
                    $firstImagePath = reset($imagePaths);
                @endphp
                <img src="{{ asset('' . $firstImagePath) }}" alt="Gambar Postingan" class="image-keranjang">
            @else
                Tidak ada gambar yang tersedia.
            @endif
            <p class="desktop-text">{{ substr($item->postingan->deskripsi, 0, 200) }}</p>
            <p class="mobile-text">{{ substr($item->postingan->deskripsi, 0, 25) }}...</p>
            <a href="{{ route('detailProduct', ['id' => $item->postingan->id]) }}" class="button-keranjang"><i
                    class="bi bi-bag-check"></i></a>
            <form action="{{ route('keranjang.hapus', ['id' => $item->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="button-keranjang"><i
                        class="bi bi-trash-fill"></i></button>
            </form>
        </div>
        <h5 style="margin-top: -5px; color: #333;">{{ $item->postingan->nama_menu }}</h5>
        <h5 style="color: #a30606; font-weight: bold;">Rp {{ number_format($item->postingan->harga, 0, ',', '.') }}
            </h5>
    </div>
    @endforeach
    @else
    <div class="no-data">
        <center><img src="{{ asset('img/no-keranjang.png') }}" alt="ini-gif" class="gif-data"></center>
        <center>
            <h6 style="margin-top: 15px; color: #000">Anda belum memiliki isi keranjang</h6>
        </center>
    </div>
    @endif
</div>
@endsection