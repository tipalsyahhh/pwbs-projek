<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('desain/css/register.css') }}">
    
</head>

<body>
    <div class="container" id="container">
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <div class="form-container sign-up-container">
                        <h2>Masukan data diri anda</h2>

                        <input type="text" name="namadepan" class="form-control" placeholder="Nama Depan" value="{{ old('namadepan') }}" required>
                
                        <input type="text" name="namabelakang" class="form-control" placeholder="Nama Belakang" value="{{ old('namabelakang') }}"required>

                        <input type="text" name="user" class="form-control" placeholder="Username" value="{{ old('user') }}" required>

                        <input type="password" name="password" placeholder="Password" class="form-control" required>

                        <label class="form-label" style="font-weight: bold;"><span>Gender</span></label>
                        <div class="gender-options">
                            <label><input type="radio" name="gender" value="male"> Male</label>
                            <label><input type="radio" name="gender" value="female"> Female</label>
                        </div>
                    
                        <!-- Input remember_token yang tersembunyi -->
                        <input type="hidden" name="remember_token"
                         value="{{ substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 60) }}">


                        <button type="submit" class="btn">Daftar</button>
                    </div>
                        <div class="overlay-container">
                            <div class="overlay">
                                <div class="overlay-panel overlay-right">
                                    <h1>Welcome Back!</h1>
                                    <p>Jika sudah punya akun mari kita login untuk mendapatkan info terbaru</p>
                                    <button onclick="window.location.href='{{ route('login') }}'" class="btn2 btn-secondary">Login</button>
                                </div>
                        </div> 
                </div>

                 
            </form>
        </div>
    </div>
</body>

</html>
