@extends('layout.master')

@section('judul')
    Edit Profil Toko Mu
@endsection

<style>
    .button {
        width: 100%;
        border-radius: 50px;
        border: 1px solid #2eada7;
        background-color: #2eada7;
        color: #FFFFFF;
        font-size: 15px;
        font-weight: bold;
        padding: 10px 45px;
        letter-spacing: 1px;
        transition: transform 80ms ease-in;
    }
</style>

@section('content')
    <form method="post" action="{{ route('datatoko.update', $datatoko->id) }}" id="edit-profile-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Depan</label>
            <input type="text" name="nama_depan" value="{{ $datatoko->nama_depan }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Nama Belakang</label>
            <input type="text" name="nama_belakang" value="{{ $datatoko->nama_belakang }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="{{ $datatoko->alamat }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="{{ $datatoko->email }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Detail</label>
            <input type="text" name="detail" value="{{ $datatoko->detail }}" class="form-control">
        </div>

        <button type="submit" class="button"><i class="bi bi-save"></i>
            Simpan</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelector('#edit-profile-form').addEventListener('submit', function(event) {
            event.preventDefault();
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
                    this.submit();
                }
            });
        });
    </script>
@endsection
