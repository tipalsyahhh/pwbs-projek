@extends('layout.master')

@section('judul')
    Tambah Profil Pengguna
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
    <form method="post" action="{{ route('dataAkun.store') }}">
        @csrf
        <div class="form-group">
            <label>Nama Depan</label>
            <input type="text" name="nama_depan" value="{{ old('nama_depan') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Nama Belakang</label>
            <input type="text" name="nama_belakang" value="{{ old('nama_belakang') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="{{ old('alamat') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Biodata</label>
            <input type="text" name="biodata" value="{{ old('biodata') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Gender</label>
            <select name="gender" class="form-control">
                <option disabled selected>Pilih Gender</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <button type="submit" class="button"><i class="bi bi-save"></i> Simpan</button>
    </form>
@endsection
