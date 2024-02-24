@extends('layout.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('desain/css/comentar.css')}}">

@section('content')
    <div class="modal-status">
        <div class="card-comen my-4">
            <div class="isi" style="display: flex; width: 100%; margin-bottom: 8px;">
                <div class="image-comen" style="width: 50%;">
                    @php
                    $imagePaths = explode(',', $status->image);
                    @endphp
                    <div id="profile-carousel-{{ $status->id }}" class="carousel">
                        <div class="carousel-inner">
                            @foreach ($imagePaths as $index => $imagePath)
                            <div class="carousel-item{{ $index === 0 ? ' active' : '' }}">
                                <img src="{{ asset($imagePath) }}" class="d-block w-100 profile-image"
                                    data-toggle="modal" data-target="#profile-modal-{{ $status->id }}-{{ $index }}"
                                    alt="Profile Image" style="border-radius:8px;">
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
                <div class="comentar" style="width: 50%; margin-left: 8px;">
                    <div class="info-posting">
                        <div class="user-postingan">
                            <img src="{{ $status->user->profileImage ? asset('storage/' . $status->user->profileImage->image_path) : asset('storage/default_profile.png') }}"
                                alt="Profile Image" class="rounded-circle"
                                style="width: 40px; height: 40px; object-fit: cover;">
                            <h8 class="mb-0" style="margin-left: 10px; color: #080808">{{ $status->user->user }}
                            </h8>
                        </div>
                    </div>

                    <div class="caption">
                        <p style="color: #080808">{{ $status->caption }}</p>
                    </div>
                    <div class="garis-comentar"></div>
                    <div class="isi-comentar">
                        @foreach ($comments as $commen)
                        @if ($commen->comentar)
                        <div class="comentar-item">
                            <img src="{{ $commen->user->profileImage ? asset('storage/' . $commen->user->profileImage->image_path) : asset('storage/default_profile.png') }}"
                                alt="Profile Image" class="rounded-circle" style="width: 40px; height: 40px;">
                            <div class="comentar-details">
                                <strong class="comment-user">{{ $commen->user->user }}</strong>
                                <p>{{ $commen->comentar }}</p>
                                <div class="comentar-user">
                                    @foreach($comments as $likeComment)
                                    @if($likeComment->comentar && $likeComment->id === $commen->id)
                                    <p id="{{ $likeComment->id }}">{{ $likeComment->created_at->diffForHumans() }}
                                    </p>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="garis-comentar"></div>
            @include('like.emoticon')
            <div class="form-comentar">
                <div class="user-info">
                    <button type="button" id="emoticon-button">
                        <i class="bi bi-emoji-smile" style="font-size: 1.5em;"></i>
                    </button>
                </div>
                <form method="post" action="{{ route('comment.add', ['status_id' => $status->id]) }}" class="mt-3"
                    id="comment-form">
                    @csrf
                    <div class="comen-group">
                        <input type="text" name="comment" class="form-control" placeholder="Add a comment...">
                        <div class="input-group-icon-comentar">
                            <button type="submit" class="kirim-comentar">
                                Post
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    // Fungsi untuk menyisipkan emotikon ke dalam input teks
    function insertEmoticon(emoticon) {
        var commentInput = document.querySelector('input[name="comment"]');
        commentInput.value += emoticon;
    }

    // Fungsi untuk menampilkan/sembunyikan kontainer emotikon saat tombol diklik
    document.getElementById('emoticon-button').addEventListener('click', function ( ) {
            // Skrip perta               var emoticonContainer = document.getElementById('emoticon-contai        );
        emoticonContainer.style.display = (emoticonContainer.style.display === 'none' || emoticonContainer.style.display === '') ? 'block'         one';

                krip kedua
        var emoticonHeader = document.getElementById('        icon-header');
        emoticonHeader.style.display = (emoticonHeader.style.display === 'none' || emoticonHeader.style.display === '    ') ? none';
    });
</script>
@endsection