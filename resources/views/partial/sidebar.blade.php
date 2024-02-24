
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="{{ asset('desain/css/sidebar.css')}}">

    <aside class="sidebar">
        <div class="logo">
            <img class="img-profile" style="width: 40px; height: 40px; border-radius: 50px; object-fit: cover;"
                src="{{ optional($user->profileImage)->image_path ? asset('storage/' . $user->profileImage->image_path) : asset('storage/default_profile.png') }}"
                alt="Profile Image">
            <h2>
                @if($user->dataakun)
                {{ $user->dataakun->nama_depan }} {{ $user->dataakun->nama_belakang }}
                @else
                {{ $user->namadepan }} {{ $user->namabelakang }}
                @endif
            </h2>
        </div>
        <ul class="links">
            <h4>Main Menu</h4>
            <li>
                <span class="material-symbols-outlined">home</span>
                <a href="{{ route('like.status') }}">Home</a>
            </li>
            <li>
                <span class="material-symbols-outlined">group</span>
                <a href="{{ route('follow.index') }}">User</a>
            </li>
            <li>
                <span class="material-symbols-outlined">add</span>
                <a href="{{ route('statuses.create') }}">Create status</a>
            </li>
            <li>
                <span class="material-symbols-outlined">storefront</span>
                <a href="{{ route('pages.welcome') }}">Market</a>
            </li>
            <hr>
            <h4>Account</h4>
            <li>
                <span class="material-symbols-outlined">person</span>
                <a href="{{ route('dataAkun.index') }}">Akun</a>
            </li>
            <li>
                <span class="material-symbols-outlined">settings</span>
                <a href="{{ route('dataAkun.setting') }}">Settings</a>
            </li>
            <li class="logout-link">
                <span class="material-symbols-outlined">logout</span>
                <a href="{{ route('logout') }}">Logout {{$user->user}}</a>
            </li>
        </ul>
    </aside>