@extends('layout.master')
<link rel="stylesheet" href="{{ asset('desain/css/histori.css')}}">

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
<p>Silakan isi profile akun anda terlebih dahulu.</p>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: "Anda Belum Mengisi Data Profile",
        text: "Silakan isi data Anda untuk melanjutkan",
        icon: "warning",
        confirmButtonColor: "#2eada7",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ route('dataAkun.create') }}";
        }
    });
</script>
@endif
@else
<h1>SELAMAT DATANG</h1>
@endif
<div class="header-history">
    <h1>History Pemesanan</h1>
</div>
<div class="container-history">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="cart-histori">
        <div class="isi-histori">
            @php
            $products = auth()->user()->products->reverse();
            @endphp

            @if($products->isEmpty())
            <center>
                <div class="no-data">
                    <img src="{{ asset('img/no-data.png') }}" alt="ini-gif" class="gif-data">
                    <h5 style="margin-top: 15px; color: #333;">Anda belum memiliki histori apapun</h5>
                </div>
            </center>
            @else
            @foreach($products as $product)
            <div class="text-histori" onclick="redirectToHistory('{{ route('history.show', $product->id) }}')">
                <p class="text-menu">{{ $product->postingan->nama_menu }}</p>
                <h6 style="white-space: normal; color: #000">anda telah melakukan pemesanan {{ $product->postingan->nama_menu }},
                    lihat histori pesanan anda untuk melihat struk pemesanan.</h6>
                <p style="color: #000">{{ $product->created_at }}</p>
            </div>
            @endforeach
            @endif
        </div>
    </div>

</div>
<script>
    function redirectToHistory(route) {
        window.location.href = route;
    }
</script>
@endsection