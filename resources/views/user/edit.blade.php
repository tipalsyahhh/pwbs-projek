@extends($user && $user->role === 'admin' ? 'layout.admin' : 'layout.master')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .reset-password p {
        color: #000;
    }

    .judul-reset {
        color: #000;
        font-weight: bold;
    }

    .login-link {
        color: #023349;
        text-decoration: none;
        transition: color 0.3s, border-bottom-color 0.3s;
        border-bottom: 1px solid transparent;
    }

    .login-link:hover {
        color: #0056b3;
        border-bottom-color: #0056b3;
    }

    .button-password {
        background-color: #2eada7;
        color: #fff;
        margin-top: 30px;
        font-weight: bold;
        border: none;
        border-radius: 50px;
        width: 100%;
        padding: 8px 10px;
    }
</style>
@section('content')
<div class="reset-password">
    <p style="margin-top: 20px;">{{ $user->user }} <span>~ Novsosiaplaze</span>
    <p>
    <h2 class="judul-reset">Ubah data akun</h2>
    <p>Anda akan merubah data pada akun anda, setelah berhasil maka anda di minta login kembali.</p>
    <form id="update-form" action="{{ route('update', $login->id) }}" method="POST">
        @if (session('success'))
        <div id="success-alert" class="alert alert-warning">
            {{ session('success') }}
        </div>
        @endif
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="user">Username:</label>
            <input type="text" name="user" value="{{ $login->user }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="nomor_handphone">Nomor Handphone:</label>
            <input type="text" name="nomor_handphone" value="{{ $login->nomor_handphone }}" required
                class="form-control">
        </div>

        <div class="form-group">
            <label for="namadepan">Nama Depan:</label>
            <input type="text" name="namadepan" value="{{ $login->namadepan }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="namabelakang">Nama Belakang:</label>
            <input type="text" name="namabelakang" value="{{ $login->namabelakang }}" required class="form-control">
        </div>

        <button type="button" id="btn-update" class="button-password"><i
                class="bi bi-save"></i> Simpan</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('btn-update').addEventListener('click', function () {
        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah Anda ingin menyimpan perubahan?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#2eada7",
            cancelButtonColor: "#2eada7",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('update-form').submit();
            }
        });
    });
    const successAlert = document.getElementById('success-alert');

    if (successAlert) {
        setTimeout(function () {
            successAlert.style.display = 'none';
        }, 10000);
    }
</script>
@endsection