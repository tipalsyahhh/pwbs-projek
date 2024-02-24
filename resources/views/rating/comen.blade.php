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

<div class="nilai-rating">
    <h5 style="color: #333; font-weight:">Penilaian Product</h5>
    @foreach ($postingan->ratings->sortByDesc('created_at') as $rating)
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
       alt="Profile Image" class="rounded-circle" style="width: 40px; height: 40px;">
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
    @endforeach
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@endsection