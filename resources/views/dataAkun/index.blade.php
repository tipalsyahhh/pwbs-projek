@extends('layout.master')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('desain/css/profile.css') }}">

@section('content')
    <audio id="like-audio" src="{{ asset('like.mp3') }}" style="display: none" loop></audio>
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card" style="margin-top: 20px;">
            @if (auth()->check() && $userProfile && $userProfile->user)
                <div class="atas-user">
                    @if ($userProfile->user->profileImage)
                        <a href="{{ route('fotoProfile.index') }}">
                            <img src="{{ asset('storage/' . $userProfile->user->profileImage->image_path) }}"
                                class="profile-image"
                                alt="Foto Profil {{ $userProfile->user->namadepan }} {{ $userProfile->user->namabelakang }}">
                        </a>
                    @else
                        <a href="{{ route('fotoProfile.index') }}">
                            <img src="{{ asset('storage/default_profile.png') }}" class="profile-image"
                                alt="Foto Profil Default">
                        </a>
                    @endif
                    <div class="profile-details ml-3">
                        <div class="info">
                            <h5 class="card-title">{{ $userProfile->user->user }}</h5>
                            <a type="button" class="button-edit" href="{{ route('dataAkun.setting') }}" style="color: #080808; text-decoration: none;">
                                <i class="bi bi-gear"></i></i> Setting
                            </a>
                        </div>
                    </div>
                </div><br />
                <h5 class="card-title" style="color:#080808; font-weight: bold;">{{ $userProfile->nama_depan }}
                    {{ $userProfile->nama_belakang }}</h5>
                <p class="card-alamat" style="color:#080808; margin-top:-5px;">
                    {{ $userProfile->biodata }}</p>
                <div class="card-text-container" style="color:#080808">
                    <p class="card-text">{{ $statusCount }} Postingan</p>
                    <p class="card-text">{{ $userProfile->user->myFollowers_count ?? 0 }} Pengikut</p>
                    <p class="card-text">{{ $userProfile->user->myFollowings_count ?? 0 }} Mengikuti</p>
                </div>
            @else
                <p>This is not your profile. You can only view your own profile.</p>
                <script>
                    window.location = "{{ route('dataAkun.create') }}";
                </script>
            @endif
            <hr class="garis-1">
            <div class="center-icon">
                <a class="nav-link" href="{{ route('like.status') }}">
                    <i class="bi bi-border-all" style="color: gray; font-size: 1.2em;"> <span>ALL POSTS</span></i>
                </a>
            </div>
            @if (
                $userProfile &&
                    $userProfile->user &&
                    $userProfile->user->myStatuses &&
                    $userProfile->user->myStatuses->isNotEmpty())
                @php
                    // Ambil status terbaru dari koleksi dan balikkan urutannya
                    $reversedStatuses = $statuses->reverse();
                @endphp

                <div class="dalam-postingan">
                    @foreach ($userProfile->user->myStatuses->reverse() as $status)
                        @if ($status->image)
                            <div class="postingan">
                                @php
                                    $imagePaths = explode(',', $status->image);
                                @endphp

                                @foreach ($imagePaths as $imagePath)
                                    <img src="{{ asset($imagePath) }}" alt="Status Image" data-toggle="modal"
                                        data-target="#profile-modal-{{ $status->id }}">
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-camera" style="color: gray; font size: 2em;"></i>
                    <p class="mt-3">Share Photos</p>
                    <center>
                        <p class="mt-2">When you share photos, they will appear on your profile.</p>
                    </center>
                    <a href="{{ route('statuses.create') }}" class="login-link"
                        style="color:#080808; text-decoration: none;">Share your first
                        photo</a>
                </div>
            @endif

            @if (
                $userProfile &&
                    $userProfile->user &&
                    $userProfile->user->myStatuses &&
                    $userProfile->user->myStatuses->isNotEmpty())
                @foreach ($userProfile->user->myStatuses as $status)
                    <div class="modal fade" id="profile-modal-{{ $status->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="info-posting">
                                        <div class="user-postingan">
                                            <img src="{{ $status->user->profileImage ? asset('storage/' . $status->user->profileImage->image_path) : asset('storage/default_profile.png') }}"
                                                alt="Profile Image" class="rounded-circle"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                            <h8 class="mb-0" style="margin-left: 10px; color: #080808">
                                                {{ $status->user->user }}
                                            </h8>
                                        </div>
                                        <div class="button-asu">
                                            <button type="button" class="button-posting" data-dismiss="modal">X
                                            </button>
                                            <button type="button" class="button-posting" data-toggle="modal"
                                                data-target="#postinganModal-{{ $status->id }}">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="postinganModal-{{ $status->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content"
                                                style="border-radius: 10px; background-color: #3a3a39">
                                                <div class="modal-body">
                                                    <form method="POST"
                                                        action="{{ route('statuses.deleteProfile', ['id' => $status->id]) }}"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus status ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-close-1">Delete</button>
                                                    </form>
                                                    <hr class="batas">
                                                    <a href="{{ route('statuses.edit', ['status' => $status]) }}"
                                                        class="button-modal-1" style="text-decoration: none;">Edit Status</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $imagePaths = explode(',', $status->image);
                                    @endphp

                                    <div id="profile-carousel-{{ $status->id }}" class="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($imagePaths as $index => $imagePath)
                                                <div class="carousel-item{{ $index === 0 ? ' active' : '' }}">
                                                    <img src="{{ asset($imagePath) }}" alt="Status Image"
                                                        class="img-fluid">
                                                </div>
                                            @endforeach
                                        </div>

                                        @if (count($imagePaths) > 1)
                                            <a class="carousel-control-prev" href="#profile-carousel-{{ $status->id }}"
                                                role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#profile-carousel-{{ $status->id }}"
                                                role="button" data-slide="next">
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
                                    <div class="button-user-like-comen">
                                        <form action="{{ route('like.add', ['status_id' => $status->id]) }}"
                                            method="POST">
                                            @csrf
                                            @if ($status->likes->where('like', 1)->where('user_id', auth()->user()->id)->count() > 0)
                                                <button type="submit" class="button-unlike" id="like-button">
                                                    <i class="bi bi-heart-fill text-danger" style="font-size: 1.5em;"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="button-like" id="like-button">
                                                    <i class="bi bi-heart" style="font-size: 1.5em;"></i>
                                                </button>
                                            @endif
                                        </form>
                                        <a href="{{ route('like.comments', ['status_id' => $status->id]) }}">
                                            <i class="far fa-comment" style="font-size: 1.5em;"></i>
                                        </a>
                                    </div>
                                    <h7 class="card-title" style="color: #080808">{{ $status->caption }}</h7>
                                    <div style="color: #080808; font-size: 12px; margin-top: 2px">
                                        {{ $status->created_at->diffForHumans() }}
                                    </div>
                                    <div class="mt-2">
                                        <span class="mr-3" style="color: #080808">
                                            <strong>{{ optional($status->like())->count() }}</strong> Suka
                                        </span>
                                        <span style="color: #080808">
                                            <strong>{{ $status->comments_count }}</strong> Comentar
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
@endsection

@push('script')
    <script>
        $('.s-image').click(function() {
            var modalId = $(this).data('target');
            $(modalId).m
        });
        document.getElementById('like-button').addEventListener('click', function() {
            var audio = document.getElementById('like-audio');
            audio.play();
        });
    </script>
@endpush
