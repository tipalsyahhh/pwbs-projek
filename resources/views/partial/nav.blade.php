<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('desain/css/nav.css') }}">

<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow fixed-top"
    style="background: linear-gradient(to right, #84e3da, #52b3d9 100%);">
    <h6 id="typedText">Novsosiaplaze</h6>
    <div class="garis"></div>
    <ul class="navbar-nav d-md-none" id="accordionSidebar">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile" style="width: 40px; height: 40px; border-radius: 50px; object-fit: cover;"
                    src="{{ optional($user->profileImage)->image_path ? asset('storage/' . $user->profileImage->image_path) : asset('storage/default_profile.png') }}" alt="Profile Image">
            </a>
        </li>
    </ul>

    <a class="sidebar-brand d-flex align-items-center justify-content-center d-md-none" style="text-decoration: none;" href="{{ route('like.status') }}">
        <div class="sidebar-brand-text ml-1" style="font-weight: bold; color: #fff">
            @if($user->dataakun)
                {{ $user->dataakun->nama_depan }} {{ $user->dataakun->nama_belakang }}
            @else
                {{ $user->namadepan }} {{ $user->namabelakang }}
            @endif
        </div>
    </a>

    <ul class="navbar-nav-1" id="accordionSidebar" id="menu">
    @auth
        @if ($user->dataToko)
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('products.userToko') }}">
                <i class="bi bi-bookmark-check" style="color: #fff; font-size: 1.2em;"></i>
                <span class="badge badge-danger badge-counter" id="notificationCounter">
                    @php
                    // Menghitung notifikasi dari tabel Products
                    $user = auth()->user();
                    $postinganCounts = optional($user)->postingan->flatMap(function ($post) {
                        return $post->products
                            ->where('status', 'menunggu')
                            ->pluck('menu_id') ?? [];
                    })->count();
                    // Menghitung notifikasi dari jenis produk lainnya
                    $totalCount = $postinganCounts + auth()->user()->unreadOrdersCount();
                    @endphp

                    @if ($totalCount > 0)
                    {{ $totalCount }}
                    @else
                    0
                    @endif
                </span>
            </a>
        </li>
        @endif
        @endauth

        @auth
        @if ($user->dataToko)
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('umum') }}">
                <i class="bi bi-bag-plus" style="color: #fff; font-size: 1.4em;"></i>
            </a>
        </li>
        @endif
        @endauth
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('keranjang.index') }}">
                <i class="bi bi-cart-check" style="color: #fff; font-size: 1.4em;"></i>
                <span class="badge badge-danger badge-counter" id="notificationCounter"
                style="position: absolute; transform: scale(0.7); margin-top: -.25rem; margin-left: -.25rem;">
                    @php
                    $keranjangCounts = $keranjang
                    ->where('user_id', auth()->user()->id)
                    ->count();

                    $totalCount =
                    $keranjangCounts +
                    auth()
                    ->user()
                    ->unreadOrdersCount();
                    @endphp

                    @if ($totalCount > 0)
                    {{ $totalCount }}
                    @else
                    0
                    @endif
                </span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('pages.notif') }}">
                <i class="fas fa-bell fa-fw" style="color: #fff; font-size: 1.2em;"></i>
                <span class="badge badge-danger badge-counter" id="notificationCounter">
                    @php
                    // Menghitung notifikasi dari tabel Products
                    $productCounts = $products->where('user_id', auth()->user()->id)
                    ->where('status', '!=', 'menunggu')
                    ->where('notifikasi', 'belum dibaca')
                    ->count();

                    // Menghitung notifikasi dari tabel Follow
                    $followCounts = $follows->where('following_user_id', auth()->user()->id)
                    ->where('notifikasi', 'belum dibaca')
                    ->count();

                    // Menghitung notifikasi dari tabel Likes
                    $likesCount = $likes->where(function ($like) {
                    return auth()->user()->id == $like->status->user_id && $like->status->user_id != $like->user_id;
                    })
                    ->where('notifikasi', 'belum dibaca')
                    ->count();

                    // Menghitung notifikasi dari jenis produk lainnya
                    $totalCount = $productCounts + $followCounts + $likesCount +
                    auth()->user()->unreadOrdersCount();
                    @endphp

                    @if ($totalCount > 0)
                    {{ $totalCount }}
                    @else
                    0
                    @endif
                </span>
            </a>
        </li>
    </ul>
    <script>
        const textElement = document.getElementById("typedText");

        function animateText() {
            textElement.style.animation = "none";
            void textElement.offsetWidth;
            textElement.style.animation = null;
            textElement.style.animation = "typing 2s steps(20, end) forwards, erasing 2s steps(20, end) 4s forwards";
        }

        setInterval(animateText, 10000);
    </script>
</nav>