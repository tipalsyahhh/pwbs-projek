@extends('layout.master')
<link rel="stylesheet" href="{{ asset('desain/css/detail.css') }}">

@section('content')
@php
use Illuminate\Support\Facades\Auth;
@endphp
@section('content')
@php
$user = Auth::user();
@endphp
@php
    use App\Models\Product;
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
        confirmButtonColor: "#5fc987",
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

<div class="header-detail">
    @if ($postingan->image)
    @php
    $imagePaths = explode(',', $postingan->image);
    @endphp

    <div id="profile-carousel-{{ $postingan->id }}" class="carousel slide" >
        <div class="carousel-inner">
            @foreach ($imagePaths as $index => $imagePath)
            <div class="carousel-item{{ $index === 0 ? ' active' : '' }}">
                <img src="{{ asset($imagePath) }}" class="d-block w-100 profile-image" alt="Profile Image"
                    data-toggle="modal" data-target="#profile-modal-{{ $postingan->id }}-{{ $index }}">
            </div>
            @endforeach
        </div>

        @if (count($imagePaths) > 1)
        <a class="carousel-control-prev" href="#profile-carousel-{{ $postingan->id }}" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#profile-carousel-{{ $postingan->id }}" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <ol class="carousel-indicators" style="cursor: none;">
            @foreach ($imagePaths as $index => $imagePath)
            <li data-target="#profile-carousel-{{ $postingan->id }}" data-slide-to="{{ $index }}"
                class="{{ $index === 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        @endif
    </div>
    @endif
    <div class="kembali">
        <a href="{{ route('pages.welcome') }}"><i class="bi bi-arrow-left" style="color: #333; font-size: 1.5em; font-weight: bold;"></i></a>
    </div>
</div>

<div class="isi-text">
    <img src="{{ $postingan->user->profileImage ? asset('storage/' . $postingan->user->profileImage->image_path) : asset('storage/default_profile.png') }}"
        alt="Profile Image" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
    <p style="color:#080808; margin-left: 8px; margin-top: 8px;">{{ optional($postingan->user->datatoko)->nama_depan }}
    {{ optional($postingan->user->datatoko)->nama_belakang }}</p>
</div>
<p style="margin-top: 5px;"><i class="bi bi-geo-alt-fill"></i> {{ optional($postingan->user->datatoko)->alamat }}</p>

<h5 style="color: #333; font-weight: bold;">{{ $postingan->nama_menu }}</h5>
    <div class="asu">
        <center>
        <div class="detail-icon">
            <p><i class="fas fa-tags"></i> {{ $postingan->jenis }}</p>
            @php
            $jumlahBeli = $postingan->products->where('status', 'disetujui')->sum('jumlah_beli');
            $sisaKapasitas = $postingan->kapasitas - $jumlahBeli;
            @endphp
            <p style="margin-left: 25px"><i class="fas fa-box"></i> {{ $sisaKapasitas }}</p>
            <p style="margin-left: 25px">Terjual : {{ $jumlahBeli }}</p>
        </div>
        </center>
    </div>
<div class="garis-detail"></div>

<div class="description">
    <h7 style="color: #333; font-weight: bold;">Description</h7>
    <p>{{ $postingan->deskripsi }}</p>
</div>

<p style="color: #333; font-weight: bold; font-size: 20px;">Total Price</p>
<div class="user-detail">
    <div class="harga-detail">
        <p class="card-text">Rp {{ number_format($postingan->harga, 0, ',', '.') }}</p>
    </div>
    @php
        $userProducts = \App\Models\Product::where('user_id', auth()->user()->id)
            ->where('menu_id', $postingan->id)
            ->get();

        $produkAda = $userProducts->isNotEmpty();

        $postinganDiterima = $produkAda && $userProducts->where('status', 'disetujui')->isNotEmpty();
    @endphp

    @if($postinganDiterima)
        <div class="comen">
            <a href="{{ route('rating.create', ['postingan_id' => $postingan->id]) }}">Beri Penilaian</a>
        </div>
    @endif
</div>

<div class="garis-detail"></div>
<div class="button-detail">
    <button class="tambahKeKeranjangButton" data-menu-id="{{ $postingan->id }}">Masukan Keranjang</button>
    <a href="{{ $sisaKapasitas > 0 ? route('products.create', ['postingan_id' => $postingan->id]) : '#' }}"
        class="cek-detail" style="margin-left: 8px;"
        onclick="{{ $sisaKapasitas > 0 ? '' : 'event.preventDefault(); Swal.fire({title: \'Produk Habis\', text: \'Mohon maaf, produk telah habis.\', icon: \'info\', confirmButtonText: \'OK\', customClass: { confirmButton: \'custom-ok-button\' } })' }}">
            <center>
                Checkout
            </center>
    </a>
</div>

@if ($postingan->ratings->where('menu_id', $postingan->id)->isNotEmpty())
    <div class="nilai-rating">
        <h5 style="color: #333; font-weight:">Penilaian Product</h5>
        @php
            $limit = 3;
            $count = 0;
        @endphp
        @foreach ($postingan->ratings->where('menu_id', $postingan->id)->sortByDesc('created_at') as $rating)
            @if($count < $limit)
                <div class="bintang-rating">
                    @for ($i = 1; $i <= $rating->rating; $i++)
                        <span class="star filled" style="color: #ffcc00;">&#9733;</span>
                    @endfor

                    @for ($i = $rating->rating + 1; $i <= 5; $i++)
                        <span class="star" style="color: #ccc;">&#9734;</span>
                    @endfor
                </div>
                <div class="user-rating">
                    <img src="{{ $rating->user->profileImage ? asset('storage/' . $rating->user->profileImage->image_path) : asset('storage/default_profile.png') }}"
                        alt="Profile Image" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                    <p style="color: #333; margin-bottom: 5px; font-weight: bold; margin-left: 10px;">{{$rating->user->user}}</p>
                </div>
                <p style="color: #333; margin-bottom: 5px;">{{ $rating->created_at->diffForHumans() }}</p>
                <div class="info-rating">
                    @foreach (explode(',', $rating->image) as $imagePath)
                        <img src="{{ asset($imagePath) }}" alt="comen-image" data-toggle="modal" data-target="#imageModal{{ $rating->id }}" style="width: 20%; height: 100%; max-width: 100%; margin-left: 5px;">
                    @endforeach
                    <div class="modal fade" id="imageModal{{ $rating->id }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $rating->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div id="imageCarousel{{ $rating->id }}" class="carousel slide">
                                        <div class="carousel-inner">
                                            @foreach (explode(',', $rating->image) as $index => $imagePath)
                                                <div class="carousel-item{{ $index === 0 ? ' active' : '' }}">
                                                    <img src="{{ asset($imagePath) }}" class="d-block w-100" alt="comen-image">
                                                </div>
                                            @endforeach
                                        </div>
                                        <a class="carousel-control-prev" href="#imageCarousel{{ $rating->id }}" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#imageCarousel{{ $rating->id }}" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="isin-comen" style="margin-top: 15px; color: #333;">
                    <p>{{$rating->comentar}}</p>
                </div>
                <div class="garis-detail-comen"></div>
            @endif
            @php
                $count++;
            @endphp
        @endforeach
        @if($count > $limit)
            <div class="banyak">
                <a href="{{ route('rating.comen', ['id' => $postingan->id]) }}" style="color: #333; text-decoration: none; font-weight: bold;">Lihat lebih banyak</a>
                <i class="bi bi-three-dots" style="margin-left: 5px;"></i>
            </div>
        @endif
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('.tambahKeKeranjangButton').click(function () {
            var postinganId = $(this).data('menu-id');

            $.ajax({
                type: 'POST',
                url: '{{ url('keranjang/tambah') }}' + '/' + postinganId,
                data: {
                '_token': '{{ csrf_token() }}',
                'postingan_id': postinganId,
            },
                success: function (data) {
                    var postinganUrl = '{{ url('postingan') }}/' + postinganId;
                    window.location.href = postinganUrl;
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
    });
    });
</script>
@endsection