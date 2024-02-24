@extends('layout.master')
<link rel="stylesheet" href="{{ asset('desain/css/histori.css') }}">


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
    <h1>Notifikasi</h1>
    <form method="POST" action="#">
        @csrf
        @foreach ($products as $product)
            @if (auth()->check() && auth()->user()->id == $product->user_id)
                <input type="hidden" name="product_id" value="{{ $product->id }}">
            @endif
        @endforeach
    </form>

    <form method="POST" action="#">
        @csrf
        @foreach ($follows as $follow)
            @if (auth()->check() && auth()->user()->id == $follow->following_user_id)
                <input type="hidden" name="follows_id" value="{{ $follow->id }}">
            @endif
        @endforeach
    </form>

    <form method="POST" action="#">
        @csrf
        @foreach ($likes as $like)
            @if (auth()->check() && auth()->user()->id == $like->status->user_id)
                <input type="hidden" name="status_id" value="{{ $like->status->id }}">
            @endif
        @endforeach
    </form>

    <button id="resetButton" class="reset">
        Sudah dibaca
    </button>
</div>
    <div class="container-history">
        <div id="success-alert" class="alert alert-warning"></div>

        <div class="cart-histori">
            <div class="isi-histori">
                @php
                    $combinedData = [];

                    // Combine and timestamp the data
                    foreach ($products as $product) {
                        if (auth()->user()->id == $product->user_id && $product->status !== 'menunggu') {
                            $combinedData[] = [
                                'timestamp' => strtotime($product->updated_at),
                                'type' => 'product',
                                'data' => $product,
                            ];
                        }
                    }

                    foreach ($follows as $follow) {
                        if (auth()->user()->id == $follow->following_user_id) {
                            $combinedData[] = [
                                'timestamp' => strtotime($follow->created_at),
                                'type' => 'follow',
                                'data' => $follow,
                            ];
                        }
                    }

                    foreach ($likes as $like) {
                        if (auth()->user()->id == $like->status->user_id && $like->status->user_id != $like->user_id) {
                            $combinedData[] = [
                                'timestamp' => strtotime($like->created_at),
                                'type' => 'like',
                                'data' => $like,
                            ];
                        }
                    }

                    // Sort the combined data by timestamp in descending order
                    usort($combinedData, function ($a, $b) {
                        return $b['timestamp'] <=> $a['timestamp'];
                    });
                @endphp

                @if (count($combinedData) > 0)
                    @foreach ($combinedData as $item)
                        @if ($item['type'] == 'product')
                            <div class="text-histori"
                                style="background-color: {{ $item['data']->notifikasi === 'sudah dibaca' ? 'white' : 'rgba(173, 216, 230, 0.5)' }};">
                                <a class="isi-notifikasi d-flex align-items-center"
                                    href="{{ route('history.show', $item['data']->id) }}">
                                    <div class="dropdown-list-image">
                                    @if ($item['data']->postingan->user->profileImage)
                                            <img src="{{ asset('storage/' . $item['data']->postingan->user->profileImage->image_path) }}"
                                                alt="Profile Photo"
                                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" />
                                        @else
                                            <img src="{{ asset('storage/default_profile.png') }}"
                                                alt="Default Profile Photo"
                                                style="width: 40px; height: 40px; border-radius: 50%;" />
                                        @endif
                                    </div>
                                    <div class="font-weight-bold" style="margin-left:15px;">
                                        <div class="text-notifikasi" style="color: black;">Status pesanan anda telah
                                            {{ $item['data']->status }} oleh
                                            {{$item['data']->postingan->user->datatoko->nama_depan}}
                                            {{$item['data']->postingan->user->datatoko->nama_belakang}}
                                            dengan pesanan {{ $item['data']->postingan->nama_menu }}<br />
                                        </div>
                                        <p>{{ $item['data']->updated_at->diffForHumans() }}</p>
                                    </div>
                                </a>
                            </div>
                        @elseif($item['type'] == 'follow')
                            <div class="text-histori"
                                style="background-color: {{ $item['data']->notifikasi === 'sudah dibaca' ? 'white' : 'rgba(173, 216, 230, 0.5)' }};">
                                <a class="isi-notifikasi d-flex align-items-center"
                                    href="{{ route('follow.profile', ['userId' => $item['data']->user->id]) }}">
                                    <div class="dropdown-list-image">
                                        @if ($item['data']->user->profileImage)
                                            <img src="{{ asset('storage/' . $item['data']->user->profileImage->image_path) }}"
                                                alt="Profile Photo"
                                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" />
                                        @else
                                            <img src="{{ asset('storage/default_profile.png') }}"
                                                alt="Default Profile Photo"
                                                style="width: 40px; height: 40px; border-radius: 50%;" />
                                        @endif
                                    </div>
                                    <div class="font-weight-bold" style="margin-left:15px;">
                                        <div class="text-notifikasi" style="color: black;">
                                            {{ $item['data']->user->user ?? 'User tidak ditemukan' }} telah mengikuti
                                            anda.<br />
                                        </div>
                                        <p>{{ $item['data']->created_at->diffForHumans() }}</p>
                                    </div>
                                </a>
                            </div>
                        @elseif($item['type'] == 'like')
                            <div class="text-histori"
                                style="background-color: {{ $item['data']->notifikasi === 'sudah dibaca' ? 'white' : 'rgba(173, 216, 230, 0.5)' }};">
                                <a class="isi-notifikasi d-flex align-items-center"
                                    href="{{ $item['data']->comentar ? route('like.comments', ['status_id' => $item['data']->status->id]) : route('status.show', ['status_id' => $item['data']->status->id]) }}">
                                    <div class="dropdown-list-image">
                                        @if ($item['data']->user->profileImage)
                                            <img src="{{ asset('storage/' . $item['data']->user->profileImage->image_path) }}"
                                                alt="Profile Photo"
                                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" />
                                        @else
                                            <img src="{{ asset('storage/default_profile.png') }}"
                                                alt="Default Profile Photo"
                                                style="width: 40px; height: 40px; border-radius: 50%;" />
                                        @endif
                                    </div>
                                    <div class="font-weight-bold" style="margin-left:15px;">
                                        <div class="text-notifikasi" style="color: black;">
                                            @if ($item['data']->comentar)
                                                {{ $item['data']->user->user }} memberikan komentar di status anda:
                                                "{{ $item['data']->comentar }}"<br />
                                            @else
                                                {{ $item['data']->user->user }} menyukai status anda<br />
                                            @endif
                                        </div>
                                        <p>{{ $item['data']->created_at->diffForHumans() }}</p>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                @else
                    <center>
                        <img src="{{ asset('img/no-data.png') }}" alt="ini-gif" class="gif-data">
                        <h6 style="margin-top: 15px; color: #000">Anda belum memiliki notifikasi apapun</h6>
                    </center>
                @endif
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function redirectToHistory(route) {
            window.location.href = route;
        }
        
        $(window).on('load', function() {
            $('#resetButton').click(function(e) {
                e.preventDefault();
                var productIds = $('input[name="product_id"]').map(function() {
                    return $(this).val();
                }).get();
                var followsIds = $('input[name="follows_id"]').map(function() {
                    return $(this).val();
                }).get();
                var likesIds = $('input[name="status_id"]').map(function() {
                    return $(this).val();
                }).get();
                if (productIds.length > 0 || followsIds.length > 0 || likesIds.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('reset.notification.count') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id: productIds.join(',')
                        },
                        success: function() {
                            console.log('Berhasil mereset notifikasi untuk produk');
                            showNotification('Notifikasi produk berhasil direset!');
                            window.location.href = '{{ route('pages.notif') }}';
                        },
                        error: function(xhr, status, error) {
                            console.error('Gagal mereset notifikasi untuk produk:', error);
                            console.log(xhr.responseText);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('reset.notification.count2') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            follows_id: followsIds.join(',')
                        },
                        success: function() {
                            console.log('Berhasil mereset notifikasi untuk follow');
                            showNotification('Notifikasi follow berhasil direset!');
                            window.location.href = '{{ route('pages.notif') }}';
                        },
                        error: function(xhr, status, error) {
                            console.error('Gagal mereset notifikasi untuk follow:', error);
                            console.log(xhr.responseText);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('reset.notification.count3') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status_id: likesIds.join(',')
                        },
                        success: function() {
                            console.log('Berhasil mereset notifikasi untuk like');
                            showNotification('Notifikasi like berhasil direset!');
                            window.location.href = '{{ route('pages.notif') }}';
                        },
                        error: function(xhr, status, error) {
                            console.error('Gagal mereset notifikasi untuk like:', error);
                            console.log(xhr.responseText);
                        }
                    });
                } else {
                    console.log('Tidak ada data yang dikirimkan.');
                }
            });

            function showNotification(message) {
                $('#success-alert').text(message).fadeIn();
                setTimeout(function() {
                    $('#success-alert').fadeOut();
                }, 10000);
            }
        });
    </script>
@endsection
