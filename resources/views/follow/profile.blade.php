@extends('layout.master')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('desain/css/profile.css') }}">
@section('content')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
            <div class="atas-user">
                @if ($userProfile->user->profileImage)
                    <img src="{{ asset('storage/' . $userProfile->user->profileImage->image_path) }}" class="profile-image"
                        alt="Foto Profil">
                @else
                    <img src="{{ asset('storage/default_profile.png') }}" class="profile-image" alt="Foto Profil Default">
                @endif
                <div class="profile-details ml-3">
                    <div class="info">
                        <h5 class="card-title">{{ $userProfile->user->user }}</h5>
                    </div>
                </div>
            </div><br />
            <h5 class="card-title" style="color:#080808; font-weight: bold;">{{ $userProfile->nama_depan }}
                {{ $userProfile->nama_belakang }}</h5>
            <p class="card-alamat" style="color:#080808">{{ $userProfile->biodata }}</p>
            <div class="card-text-container" style="color:#080808 margin-top:-5px; margin-left:-8px;">
                <p class="card-text" style="color: #080808">{{ $statusCount }} Postingan</p>
                <p class="card-text" style="color: #080808">{{ $userProfile->user->myFollowers_count ?? 0 }} Pengikut</p>
                <p class="card-text" style="color: #080808">{{ $userProfile->user->myFollowings_count ?? 0 }} Mengikuti</p>
            </div>

            <div class="colum-stalking">
                <div class="ml-1" style="width: 100%; margin-right: 10px;">
                    @if (auth()->user()->following->contains($userItem->id))
                        <form action="{{ route('follow.unfollow', ['userId' => $userItem->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="button-unfollow">Unfollow</button>
                        </form>
                    @else
                        <form action="{{ route('follow.follow', ['userId' => $userItem->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="button-follow">Follow</button>
                        </form>
                    @endif
                </div>
                <div class="kepo" style="width: 100%;">
                    <a href="{{ route('datatoko.index', ['userId' => $userItem->id]) }}" class="button-follow" style="color: #333; text-decoration: none;">
                        <i class="bi bi-shop-window" style="color: black; font-size: 1.2em;"></i> Lihat Toko</a>
                </div>
            </div>

            <hr class="garis-1">
            <div class="center-icon">
                <a class="nav-link" href="{{ route('like.status') }}">
                    <i class="bi bi-border-all" style="color: gray; font-size: 1.2em;"> <span>ALL POSTS</span></i>
                </a>
            </div>

            @if ($userProfile->user->myStatuses->isNotEmpty())
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
                    <i class="bi bi-camera" style="color: gray; font-size: 2em;"></i>
                    <p class="mt-3">No Posts Yet.</p>
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
                                                style="width: 40px; height: 40px;">
                                            <h8 class="mb-0" style="margin-left: 10px; color: #080808">
                                                {{ $status->user->user }}
                                            </h8>
                                        </div>
                                        <div class="button-asu">
                                            <button type="button" class="button-posting" data-dismiss="modal">X
                                            </button>
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
                                            @if ($status->isLikedBy(auth()->user()->id))
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
                                            <strong>{{ optional($status->like())->count() }}</strong> Likes
                                        </span>
                                        <span style="color: #080808">
                                            <strong>{{ $status->comments_count }}</strong> Comments
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        <div class="card-footer">
            <p>Ini adalah footer Anda</p>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('.status-image').click(function() {
            var modalId = $(this).data('target');
            $(modalId).modal('show');
        });
    </script>
@endpush
