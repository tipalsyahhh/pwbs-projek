<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('desain/css/login.css') }}">
</head>
<style>
    .overlay {
        background-image: url("{{ asset('img/contoh.gif') }}");
        background-size: cover;
        background-size: cover;
        background-position: 0 0;
        color: #FFFFFF;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }
</style>

<body>
    <div class="container" id="container">
        <center>
            <form method="POST" action="{{ route('login.authenticate') }}" id="form-case">
                @csrf
                <div class="form-container sign-in-container">
                    <!-- Login form contents -->
                    <h1>Login</h1>
                    <span>Masukkan Akun Anda</span>
                    @if (session()->has('error'))
                        <div id="success-alert" class="alert alert-warning">
                            {{ session('error') }}
                        </div>
                    @endif
                    <input type="text" name="user" class="form-login" value="{{ old('user') }}"
                        id="inputUsername" placeholder="Username" required>
                    <input type="password" name="password" class="form-login" id="inputPassword" placeholder="Password"
                        required>
                    <button>Login</button>
                </div>
            </form>
        </center>
        <div class="card-register">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <div class="form-container sign-up-container">
                        <h2>Register hire</h2>

                        <center>
                            <div class="from-register">
                                <input type="text" name="namadepan" class="form-control" placeholder="Nama Depan"
                                    value="{{ old('namadepan') }}" required>

                                <input type="text" name="namabelakang" class="form-control"
                                    placeholder="Nama Belakang" value="{{ old('namabelakang') }}" required>

                                <input type="text" name="user" class="form-control" placeholder="Username"
                                    value="{{ old('user') }}" required>

                                <input type="text" name="nomor_handphone" class="form-control"
                                    placeholder="Nomor Handphone" value="{{ old('nomor_handphone') }}" required>

                                <input type="password" name="password" placeholder="Password" class="form-control"
                                    required>
                            </div>
                        </center>
                        <input type="hidden" name="remember_token"
                            value="{{ substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 60) }}">
                        <button type="submit" class="btn-register" style="margin-top: 15px;">Daftar</button>
                    </div>
            </form>
        </div>
        <div class="overlay-container">
            <!-- Registration form contents -->
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Jika belum punya akun silakan registrasi terlebih dahulu</p>
                    <div class="btn-register">
                        <button id="register">register</button>
                    </div>
                </div>
                <div class="overlay-panel overlay-left">
                    <h2>Welcome Back!</h2>
                    <p>Jika sudah punya akun mari kita login untuk mendapatkan info terbaru</p>
                    <div class="btn-register">
                        <button id="login">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('desain/js/login.js') }}"></script>

</body>

</html>
