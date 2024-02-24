@extends('layout.master')

@php
use Illuminate\Support\Facades\Auth;
@endphp

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" />

<link rel="stylesheet" href="{{ asset('desain/css/welcome.css') }}">
<style>
    .header-market{
        width:100%;
        display: flex;
        margin-top: 40px;
        align-items: center; 
    }
    
    .input-market{
        width: 100%;
        border-radius: 50px;
        height: auto;
    }

    .container-termurah {
        text-decoration: none;
        width: 100%;
        display: flex;
        flex-wrap: nowrap;
        justify-content: flex-start;
        overflow-x: auto;
        padding: 10px;
    }

    .card-harga {
        width: 50%;
        height: auto;
        box-shadow: 5px 5px 10px #bfbebe;
        border-radius: 20px;
        padding: 10px;
        flex: 0 0 auto;
        margin-right: 15px;
        background-color: #F5F7F8;
    }

    .isi-harga{
        display: flex;
    }

    .detail-harga{
        margin-top: auto;
    }

    .isi-harga img{
        width: 150px;
        margin-left: auto;
        height: 100%;
    }
    
    .container-market {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .card-market {
        width: 48%;
        box-shadow: 5px 5px 10px #bfbebe;
        border-radius: 10px;
        padding: 10px;
        background-color: #F5F7F8;
    }

    .container-kategori{
        width: 100%;
        white-space: nowrap;
        overflow-x: auto;
        margin-bottom: 10px;
        text-decoration: none;
        display: flex;
    }

    .kategori-button {
        background-color: rgba(0, 0, 0, 0.0);;
        color: black;
        border: 1px solid #2eada7;
        padding: 5px 10px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 10px;
        border-radius: 50px;
        margin-right: 5px;
    }

    .kategori-button.active{
        background-color: #2eada7;
        padding: 5px 10px;
        font-weight: bold;
        border: none;
        margin-top: 10px;
        border-radius: 50px;
        color: #fff;
        display: inline-block; 
    }

    .modal-market {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        width: 80%;
        max-width: 600px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.49);
    }

    .modal-content-market {
        position: relative;
    }

    .close {
        cursor: pointer;
    }

    #allButtonsContainer {
        text-align: center;
    }

    .description {
      margin-bottom: 10px;
    }

    .description .desktop-text {
        display: none; 
    }

    .description .mobile-text {
        display: inline;
    }

    .habis{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50px;
        width: 70px;
    }
    .info-post {
        display: flex;
        width: 100%;
        font-size: 15px;
    }

    .rating{
        margin-left: auto;
        color: #ffcc00;
        font-weight: bold;
    }

    @media screen and (max-width: 768px) {
        .card-harga {
            width: 100%;
        }

        .caption .desktop-text {
            display: none;
        }

        .deskstop{
            display: none;
        }
    }

    @media screen and (min-width: 769px) {
        .caption .mobile-text {
            display: none;
        }

        .mobile{
            display: none;
        }
    }
</style>
@endpush

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

<div class=header-market>
    <div class="input-market">
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text bg-light border-0" style="border-radius: 50px 0 0 50px;">
                    <i class="fas fa-search fa-sm"></i>
                </span>
            </div>
            <input type="text" class="form-control bg-light border-0 small" id="searchMenu"
                placeholder="Cari product pilihan anda..." aria-label="Search" aria-describedby="basic-addon2" style="border-radius: 0 50px 50px 0;">
        </div>
    </div>
</div>

<div id="noResultsMessage" style="display: none; color: #333; font-weight: bold;">
    <center>Pencarian tidak ditemukan</center>
</div>

@php
$postingan = $postingan->reverse();
@endphp

@php
    $uniqueJenis = \App\Models\Postingan::distinct('jenis')->pluck('jenis');
    $postsSortedByPrice = $postingan->sortBy('harga')->reject(function ($post) {
        $jumlahBeli = $post->products->where('status', 'disetujui')->sum('jumlah_beli');
        return ($post->kapasitas - $jumlahBeli) <= 0;
    })->take(2);
@endphp

<p style="color: #333; margin-bottom: -15px; margin-top: 10px; font-size: 20px; font-weight: bold;">Spesial Terhemat</p>
<div class="container-termurah" id="filtered-posts-container">
    @forelse ($postsSortedByPrice as $post)
        @php
            $jumlahBeli = $post->products->where('status', 'disetujui')->sum('jumlah_beli');
            $sisaKapasitas = $post->kapasitas - $jumlahBeli;
        @endphp

        <div class="card-harga" style="margin-top: 20px;">
            <a href="{{ route('detailProduct', ['id' => $post->id]) }}" style="text-decoration: none;">
                <div class="isi-harga">
                    <div class="detail-harga">
                        <div class="caption menu-name" style="margin-bottom: 10px;">
                            <p class="desktop-text">{{ substr($post->nama_menu, 0, 350) }}</p>
                            <p class="mobile-text">{{ substr($post->nama_menu, 0, 25) }}...</p>
                        </div>
                        <div class="produk-isi">
                            <p class="description">
                                <i class="fas fa-box"></i>
                                @php
                                    $jumlahBeli = $post->products->where('status', 'disetujui')->sum('jumlah_beli');
                                    $sisaKapasitas = $post->kapasitas - $jumlahBeli;
                                @endphp
                                <span>{{ $sisaKapasitas}}</span>
                            </p>
                            <p style="margin-left: 25px">{{ $jumlahBeli }} Terjual</p>
                        </div>
                        <p class="harga-masuk"><span>Rp {{ number_format($post->harga, 0, ',', '.') }}</span></p>
                    </div>
                    @if ($post->image)
                        @php
                            $imagePaths = explode(',', $post->image);
                            $firstImagePath = trim($imagePaths[0]);
                        @endphp
                        <img src="{{ asset($firstImagePath) }}" alt="Gambar Postingan">
                    @else
                        <p>Tidak ada gambar yang tersedia.</p>
                    @endif
                </div>
            </a>
        </div>
    @empty
        <center><p style="color: #333; font-weight: bold; margin-top: 15px;">Belum ada data</p></center>
    @endforelse
</div>

<p style="color: #333; margin-bottom: -5px; margin-top: 25px; font-size: 20px; font-weight: bold;">Kategori</p>
<div id="container-kategori" class="container-kategori">
    <button class="kategori-button" data-jenis="all">All</button>
    <div class="deskstop">
        @foreach ($uniqueJenis as $key => $jenis)
            @if ($key < 5)
                <button class="kategori-button" data-jenis="{{ $jenis }}">{{ $jenis }}</button>
            @endif
        @endforeach

        @if (count($uniqueJenis) > 5)
            <button class="kategori-button lainnya-button" data-jenis="lainnya">Lainnya</button>
        @endif
    </div>

    <div class="mobile">
        @foreach ($uniqueJenis as $key => $jenis)
            @if ($key < 3)
                <button class="kategori-button" data-jenis="{{ $jenis }}">{{ $jenis }}</button>
            @endif
        @endforeach

        @if (count($uniqueJenis) > 3)
            <button class="kategori-button lainnya-button" data-jenis="lainnya">Lainnya</button>
        @endif
    </div>
</div>

<div id="myModal" class="modal-market">
    <div class="modal-content-market">
        <span class="close">&times;</span>
        <div id="allButtonsContainer"></div>
    </div>
</div>

<div class="container-market" id="filtered-posts-container">
@forelse ($postingan as $post)
    <a href="{{ route('detailProduct', ['id' => $post->id]) }}">
        <div class="card-market product-item post" style="margin-top: 20px; position: relative;" data-jenis="{{ $post->jenis }}">
            <a href="{{ route('detailProduct', ['id' => $post->id]) }}">
                @if ($post->image)
                    @php
                        $imagePaths = explode(',', $post->image);
                        $firstImagePath = trim($imagePaths[0]);
                    @endphp
                    <img src="{{ asset($firstImagePath) }}" alt="Gambar Postingan" class="d-block w-100 profile-image">
                @else
                    <p>Tidak ada gambar yang tersedia.</p>
                @endif
                <div class="caption menu-name" style="margin-top: 10px; margin-bottom: 10px;">
                    <p class="desktop-text">{{ substr($post->nama_menu, 0, 350) }}</p>
                    <p class="mobile-text">{{ substr($post->nama_menu, 0, 25) }}...</p>
                </div>
                <div class="produk-isi">
                    @php
                        $jumlahBeli = $post->products->where('status', 'disetujui')->sum('jumlah_beli');
                        $sisaKapasitas = $post->kapasitas - $jumlahBeli;
                    @endphp
                    <p><i class="fas fa-box"></i> {{ $sisaKapasitas }}</p>
                    @if ($sisaKapasitas == 0)
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); text-align: center; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                            <div class="habis">
                                <p style="color: white; font-size: 20px; margin: 0;">Habis</p>
                            </div>
                        </div>
                    @endif
                    <p style="margin-left: 25px">{{ $jumlahBeli }} Terjual</p>
                </div>
                <div class="info-post">
                    <p class="harga-masuk"><span>Rp {{ number_format($post->harga, 0, ',', '.') }}</span></p>
                    @if ($averageRatingMap && array_key_exists($post->id, $averageRatingMap))
                        <div class="rating">
                            <span class="star filled">&#9733;</span>
                            <span class="rating-text">{{ round($averageRatingMap[$post->id], 2) }}/5</span>
                        </div>
                    @else
                        <p>Belum ada nilai untuk postingan ini.</p>
                    @endif
                </div>
            </a>
        </div>
    </a>
@empty
    <center><p style="color: #333; font-weight: bold;">Belum ada data</p></center>
@endforelse

</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    const searchMenuInput = document.getElementById('searchMenu');
    const noResultsMessage = document.getElementById('noResultsMessage');
    searchMenuInput.addEventListener('input', function () {
        const keyword = searchMenuInput.value.toLowerCase();
        const productItems = document.querySelectorAll('.product-item');
        let resultsFound = false;
        productItems.forEach(function (item) {
            const menuName = item.querySelector('.menu-name p').textContent.toLowerCase();
            if (menuName.includes(keyword)) {
                item.style.display = 'block';
                resultsFound = true;
            } else {
                item.style.display = 'none';
            }
        });
        if (!resultsFound) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    });
    $(document).ready(function () {
        $('.kategori-button').click(function () {
            $('.kategori-button').removeClass('active');
            $(this).addClass('active');

            var jenisFilter = $(this).data('jenis');
            if (jenisFilter === 'all') {
                $('.post').show();
            } else {
                $('.post').hide();
                $('.post[data-jenis="' + jenisFilter + '"]').show();
            }
        });

        $('.lainnya-button').click(function () {
            $('#myModal').css('display', 'block');
            $('#allButtonsContainer').empty();

            @foreach ($uniqueJenis as $jenis)
                $('#allButtonsContainer').append('<button class="kategori-button" data-jenis="{{ $jenis }}">{{ $jenis }}</button>');
            @endforeach
        });

        $('.close').click(function () {
            $('#myModal').css('display', 'none');
        });

        $(window).click(function (event) {
            if (event.target == $('#myModal')[0]) {
                $('#myModal').css('display', 'none');
            }
        });

        $('#allButtonsContainer').on('click', '.kategori-button', function () {
            var jenisFilter = $(this).data('jenis');
            if (jenisFilter === 'all') {
                $('.post').show();
            } else {
                $('.post').hide();
                $('.post[data-jenis="' + jenisFilter + '"]').show();
            }
        });
    });
</script>

@endsection