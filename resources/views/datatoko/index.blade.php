@extends('layout.master')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>        
        .judul-toko {
            height: 200px;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.49);
            margin-top: 30px;
            background-color: #fff;
        }

        .judul-toko h3{
            color: #2eada7;
            font-weight: bold;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .nama-toko{
            display: flex;
            justify-content: center;
            color: #333;
        }

        .alamat{
            display: flex;
            align-items: center;
            color: #333;
        }

        .alamat p{
            margin-bottom: 10px;
        }

        .input-market{
            width: 100%;
            border-radius: 50px;
            height: auto;
            margin-top: 20px;
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

        .caption p {
            margin-top: 15px;
            margin-bottom: 5px;
            margin-left: 4px;
            color: #080808;
        }

        .produk-isi {
            display: flex;
        }

        .produk-isi p {
            color: #080808;
        }

        .harga-masuk {
            color: #a30606;
            font-weight: bold;
        }

        .no-data {
            margin-top: 10px;
        }

        .gif-data{
            width: 60%;
        }

        @media (max-width: 768px) {
            .produk-isi {
                display: flex;
                font-size: 14px;
            }
        
            .gif-data{
                width: 100%;
                margin-top: 20px;
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

    @php
        $postingan = $postingan->reverse();
    @endphp

    <div class="judul-toko">
        <?php
            $user_id = request()->segment(2);
            $toko = \App\Models\DataToko::join('login', 'toko.user_id', '=', 'login.id')
                ->where('login.id', '=', $user_id)
                ->select('toko.nama_depan', 'toko.nama_belakang', 'toko.alamat', 'toko.email', 'login.created_at')
                ->first();
        ?>
        <center><h3>Novsosiaplaze</h3></center>
        @if ($toko)
        <div class="nama-toko">
            <h5 style="font-weight: bold;"><i class="bi bi-shop" style="margin-right: 10px; font-size: 1.2em;"></i>{{ $toko->nama_depan }} {{ $toko->nama_belakang }}</h5>
        </div>
        <div class="alamat">
            <p><i class="bi bi-person-fill-add" style="margin-right: 5px; font-size: 1em;"></i>Bergabung : {{ \Carbon\Carbon::parse($toko->created_at)->diffForHumans() }}</p>
            @if (auth()->check() && $userProfile && $userProfile->user)
            <p class="card-text" style="margin-left: auto;"><i class="bi bi-box-seam" style="margin-right: 5px; font-size: 1em;"></i>Product : {{ $statusCount }}</p>
            @endif
        </div>
        <div class="alamat">
            @if (auth()->check() && $userProfile && $userProfile->user)
            <p class="card-text"><i class="bi bi-person-check" style="margin-right: 5px; font-size: 1em;"></i>Mengikuti : {{ $userProfile->user->myFollowings_count ?? 0 }}</p>
            <p class="card-text" style="margin-left: auto;"><i class="bi bi-people" style="margin-right: 5px; font-size: 1em;"></i>Pengikut : {{ $userProfile->user->myFollowers_count ?? 0 }}</p>
            @endif
        </div>
        @else
            <center><p>User belum membuka toko</p></center>
        @endif
    </div>
    @php
    $userData = \App\Models\Login::find($user_id);
    @endphp
    @if ($userData && $userData->datatoko)
            <div class="input-market">
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0" style="border-radius: 50px 0 0 50px;">
                            <i class="fas fa-search fa-sm"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control bg-light border-0 small" id="searchMenu"
                        placeholder="Cari produk pilihan anda..." aria-label="Search" aria-describedby="basic-addon2"
                        style="border-radius: 0 50px 50px 0;">
                </div>
            </div>
    @endif
    <div class="container-market" id="filtered-posts-container">
        @forelse ($postingan as $post)
        <a href="{{ route('detailProduct', ['id' => $post->id]) }}">
            <div class="card-market product-item post" style="margin-top: 20px;" data-jenis="{{ $post->jenis }}">
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
                    <div class="caption menu-name">
                        <p>{{ $post->nama_menu }}</p>
                    </div>
                    <div class="produk-isi">
                    @php
                        $jumlahBeli = $post->products->where('status', 'disetujui')->sum('jumlah_beli');
                        $sisaKapasitas = $post->kapasitas - $jumlahBeli;
                    @endphp
                        <p><i class="fas fa-box"></i> {{ $post->kapasitas }}</p>
                        <p style="margin-left: 25px">{{ $jumlahBeli }} Terjual</p>
                    </div>
                    <p class="harga-masuk"><span>Rp {{ number_format($post->harga, 0, ',', '.') }}</span></p>
                </a>
            </div>
            @empty
            <center>
                <div class="no-data">
                    <img src="{{ asset('img/no-data.png') }}" alt="ini-gif" class="gif-data">
                </div>
            </center>
        </a>
        @endforelse
    </div>

    <center>
        <div id="noResultsMessage" style="display: none; color: black; font-weight: bold;">
            Pencarian tidak ditemukan
        </div>
    </center>

    <script>
        const searchMenuInput = document.getElementById('searchMenu');
        const noResultsMessage = document.getElementById('noResultsMessage');
        searchMenuInput.addEventListener('input', function() {
            const keyword = searchMenuInput.value.toLowerCase();
            const productItems = document.querySelectorAll('.product-item');
            let resultsFound = false;
            productItems.forEach(function(item) {
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
    </script>
@endsection
