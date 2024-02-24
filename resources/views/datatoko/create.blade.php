@extends('layout.master')


@section('content')
    <form method="post" action="{{ route('datatoko.store') }}">
        @csrf
        <div class="form-group" style="margin-top: 10px;">
            <label>Nama Depan Toko</label>
            <input type="text" name="nama_depan" value="{{ old('nama_depan') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Nama Belakang Toko</label>
            <input type="text" name="nama_belakang" value="{{ old('nama_belakang') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="{{ old('email') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Alamat Toko</label>
            <input type="text" name="alamat" value="{{ old('alamat') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Detail</label>
            <input type="text" name="detail" value="{{ old('detail') }}" class="form-control">
        </div>

        <button type="submit" class="btn" style="background-color: #2eada7; color: white;"><i class="bi bi-save"></i>
            Simpan</button>
    </form>
@endsection
