@extends('layout.master')

<link rel="stylesheet" href="{{ asset('desain/css/status.css')}}">
<style>

</style>
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
<div class="container">
    <div class="row justify-content-center" style="width: 100%;">
        <div class="col-md-8">
            <div class="d-flex align-items-center" style="margin-bottom:20px;">
                <div class="user-postingan">
                    <img class="img-profile rounded-circle" style="width: 40px; height: 40px; margin-right: 5px; object-fit: cover;"
                        src="{{ $user->profileImage ? asset('storage/' . $user->profileImage->image_path) : asset('storage/default_profile.png') }}">
                </div>
                <a href="{{ route('statuses.create') }}" class="form-control"
                    style="text-decoration: none; border-radius: 50px;">
                    Apa yang anda fikirkan?
                </a>
            </div>

            @php
            $statuses = $statuses->reverse();
            @endphp
            
            @foreach ($statuses as $status)
            <div id="status-{{ $status->id }}" class="modal-status">
                <div class="modal-body">
                    <a style="text-decoration: none;" href="{{ auth()->user()->id == $status->user_id ? route('dataAkun.index') : route('follow.profile', ['userId' => $status->user_id]) }}">
                        <div class="info-posting">
                            <div class="user-postingan">
                                <img src="{{ $status->user->profileImage ? asset('storage/' . $status->user->profileImage->image_path) : asset('storage/default_profile.png') }}"
                                    alt="Profile Image" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                <h8 class="mb-0" style="margin-left: 10px; color: #080808">{{ $status->user->user }}
                                </h8>
                            </div>
                        </div>
                    </a>
                    @php
                    $imagePaths = explode(',', $status->image);
                    @endphp

                    <div class="wadah-foto">
                        <div id="profile-carousel-{{ $status->id }}" class="carousel">
                            <div class="carousel-inner">
                                @foreach ($imagePaths as $index => $imagePath)
                                <div class="carousel-item{{ $index === 0 ? ' active' : '' }}">
                                    <img src="{{ asset($imagePath) }}" class="d-block w-100 profile-image"
                                        data-toggle="modal" data-target="#profile-modal-{{ $status->id }}-{{ $index }}"
                                        alt="Profile Image">
                                </div>
                                @endforeach
                            </div>

                            @if (count($imagePaths) > 1)
                            <a class="carousel-control-prev" href="#profile-carousel-{{ $status->id }}" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#profile-carousel-{{ $status->id }}" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                            <ol class="carousel-indicators" style="cursor: none;">
                                @foreach ($imagePaths as $index => $imagePath)
                                <li class="{{ $index === 0 ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>
                            @endif
                        </div>
                    </div>

                    @foreach ($imagePaths as $index => $imagePath)
                    <div class="modal fade" id="profile-modal-{{ $status->id }}-{{ $index }}" tabindex="-1"
                        role="dialog" aria-labelledby="profile-modal-label-{{ $status->id }}-{{ $index }}"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="{{ asset($imagePath) }}" class="img-fluid" alt="Profile Image">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="button-user-like-comen">
                        <form action="{{ route('like.add', ['status_id' => $status->id]) }}" method="POST">
                            @csrf
                            @if($status->likes->where('like', 1)->where('user_id', auth()->user()->id)->count() > 0)
                            <button type="submit" class="button-unlike" id="like-button">
                                <i class="bi bi-heart-fill text-danger" style="font-size: 1.5em;"></i>
                            </button>
                            @else
                            <button type="submit" class="button-like" id="like-button">
                                <i class="bi bi-heart" style="font-size: 1.5em;"></i>
                            </button>
                            @endif
                            <audio id="like-audio" src="{{ asset('like.mp3') }}" style="display: none" loop></audio>
                        </form>
                        <a href="{{ route('like.comments', ['status_id' => $status->id]) }}">
                            <i class="far fa-comment" style="font-size: 1.5em;"></i>
                        </a>
                    </div>
                    <h7 class="card-title" style="color: #080808">{{ $status->caption }}</h7>
                    <div class="mt-2">
                        <span class="mr-3 likeSpan" style="color: #080808; text-decoration: none; cursor: pointer;"
                            data-user-id="{{ $status->user_id }}" data-status-id="{{ $status->id }}"
                            id="likeSpan-{{ $status->id }}">
                            <strong class="likeCountDisplay">{{ optional($status->like())->count() }}</strong> Suka
                        </span>
                        <span style="color: #080808">
                            <strong>{{ $status->comments_count }}</strong> Comentar
                        </span>
                    </div>
                    <div class="form-comentar">
                        <div class="user-info">
                            <img class="img-profile-comentar rounded-circle"
                                style="width: 30px; height: 30px; margin-right: 3px; object-fit: cover;"
                                src="{{ $user->profileImage ? asset('storage/' . $user->profileImage->image_path) : asset('storage/default_profile.png') }}">
                        </div>
                        <form method="post" action="{{ route('comment.add', ['status_id' => $status->id]) }}"
                            class="mt-3" id="comment-form">
                            @csrf
                            <div class="comen-group">
                                <input type="text" name="comment" class="form-comen"
                                    placeholder="berikan komentar anda...">
                            </div>
                        </form>
                    </div>
                    <div style="color: #080808; font-size: 12px; margin-top: -10px">
                        {{ $status->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @foreach ($statuses as $status)
        <div id="likedUsersModal-{{ $status->id }}" class="modal">
            <div class="modal-asu-like">
                <span class="close" data-status-id="{{ $status->id }}"
                    id="closeModalBtn-{{ $status->id }}">&times;</span>
                <div class="judul-like">
                    <h5 style="color: #333; margin-right: auto">di sukai oleh</h5>
                    <h5 style="color: 333;">{{ optional($status->like())->count() }} suka</h5>
                </div>
                <div class="garis-like"></div>
                <div class="isi-like-modal">
                    <div id="likedUsersList-{{ $status->id }}" data-liked-users="{{ json_encode($status->likes) }}">
                        @forelse ($status->likes->sortByDesc('created_at') as $like)
                            @if ($like->comentar == null && $like->status_id == $status->id)
                                <div class="modal-like">
                                    <div class="name-user">
                                        <a href="{{ auth()->user()->id == $like->user_id ? route('dataAkun.index') : route('follow.profile', ['userId' => $like->user_id]) }}" style="text-decoration: none;">
                                            <img src="{{ $like->user->profileImage ? asset('storage/' . $like->user->profileImage->image_path) : asset('storage/default_profile.png') }}" alt="Profile Image" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @if (auth()->user()->id == $like->user_id)
                                                <p style="color: black;">Anda</p>
                                            @else
                                                <p style="color: black; margin-bottom: 3px;">{{ $like->user->user }}</p>
                                                <p style="color: black;">{{ optional($like->user->dataakun)->nama_depan }} {{ optional($like->user->dataakun)->nama_belakang }}</p>
                                            @endif
                                        </a>
                                    </div>
                                    @if (!auth()->check() || auth()->user()->id !== $like->user_id)
                                        <div class="follow-user">
                                            @php
                                                $isFollowing = auth()->user()->following->contains('id', $like->user_id);
                                            @endphp

                                            @if($isFollowing)
                                            <form action="{{ route('follow.unfollow', ['userId' => $like->user_id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="button-follow">Unfollow</button>
                                            </form>
                                            @else
                                                <form action="{{ route('follow.follow', ['userId' => $like->user_id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="button-follow">Follow</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @empty
                            <p>Belum ada yang menyukai.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function lihatId() {
            var splits = window.location.href.split('/');
            var statusElement = document.getElementById(`status-${splits[splits.length - 1]}`);
            if (statusElement) {
                var headerOffset = 65;
                var elementPosition = statusElement.getBoundingClientRect().top;
                var offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                window.scrollTo({ behavior: 'smooth', top: offsetPosition });
            }
        };
        
        lihatId();

        var likeSpans = document.querySelectorAll('.likeSpan');

        likeSpans.forEach(function (likeSpan) {
            likeSpan.addEventListener('click', function () {
                var userId = this.getAttribute('data-user-id');
                var statusId = this.getAttribute('data-status-id');

                if (userId !== null && userId !== undefined && statusId !== null && statusId !== undefined) {
                    var modal = document.getElementById('likedUsersModal-' + statusId);

                    console.log('Teks Likes diklik');

                    if (modal) {
                        modal.style.display = 'block';
                    } else {
                        console.error('Elemen modal dengan ID "likedUsersModal-' + statusId + '" tidak ditemukan.');
                    }
                } else {
                    console.error('Atribut data-user-id atau data-status-id tidak diatur pada elemen .likeSpan.');
                }
            });
        });
        var closeModalBtns = document.querySelectorAll('.close');

        closeModalBtns.forEach(function (closeModalBtn) {
            closeModalBtn.addEventListener('click', function () {
                var statusId = this.getAttribute('data-status-id');
                if (statusId !== null && statusId !== undefined) {
                    var modal = document.getElementById('likedUsersModal-' + statusId);
                    if (modal) {
                        modal.style.display = 'none';
                    } else {
                        console.error('Elemen modal dengan ID "likedUsersModal-' + statusId + '" tidak ditemukan.');
                    }
                } else {
                    console.error('Atribut data-status-id tidak diatur pada elemen .close.');
                }
            });
        });
        window.addEventListener('click', function (event) {
            likeSpans.forEach(function (likeSpan) {
                var statusId = likeSpan.getAttribute('data-status-id');
                if (statusId !== null && statusId !== undefined) {
                    var modal = document.getElementById('likedUsersModal-' + statusId);

                    if (event.target === modal) {
                        modal.style.display = 'none';
                    }
                } else {
                    console.error('Atribut data-status-id tidak diatur pada elemen .likeSpan.');
                }
            });
        });
    });
    document.getElementById('like-button').addEventListener('click', function () {
        var audio = document.getElementById('like-audio');
        audio.play();
    });

    const profileImages = document.querySelectorAll('.profile-image');
    profileImages.forEach(image => {
        image.addEventListener('click', function () {
            const imgSrc = image.getAttribute('src');
            $('#profile-modal img').attr('src', imgSrc);
        });
    });
    function submitForm() {
        document.getElementById('likeForm').submit();
    }
</script>
@endsection