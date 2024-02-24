@extends($user && $user->role === 'admin' ? 'layout.admin' : 'layout.master')

@section('judul')
    Reset Password
@endsection

<link rel="stylesheet" href="{{ asset('desain/css/reset.css') }}">

@section('content')
    @if (session('success'))
        <div id="success-reset" class="alert alert-warning">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div id="error-reset" class="alert alert-warning">
            {{ session('error') }}
        </div>
    @endif
    <div class="reset-password">
        <p>{{ $user->user }} <span>~ Novsosiaplaze</span>
        <p>
        <h2 class="judul-reset">Ubah kata sandi</h2>
        <p>Anda akan menggunakan password baru silahkan login ulang setelah berhasil melakukan ubah pada password.</p></br>
        <p>Kata Sandi Anda minimal dari delapan karakter dan berisi kombinasi angka,huruf, dan karakter khusus (!$@%).</p>
        <form method="POST" action="{{ route('password.reset', ['token' => $token]) }}">
            @csrf
            <input type="hidden" name="username" value="{{ $username }}">
            <div class="form-group">
                <input type="password" name="old_password" id="old_password"
                    class="form-control @error('old_password') is-invalid @enderror" placeholder="Kata sandi saat ini"
                    required>
                @error('old_password')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="Password baru" required
                    autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    placeholder="Konfirmasi password baru" required autocomplete="new-password">
            </div>

            <div class="button-password-user">
                <button type="submit" class="button-password">Ubah Kata
                    Sandi</button>
            </div>
        </form>
    </div>

    <script>
        const successAlert = document.getElementById('success-reset');
        const errorAlert = document.getElementById('error-reset');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 10000);
        }

        if (errorAlert) {
            setTimeout(function() {
                errorAlert.style.display = 'none';
            }, 10000);
        }
    </script>
@endsection
