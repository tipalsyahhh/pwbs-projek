@extends('layout.admin')

@section('content')
@section('judul')
    Daftar Pengguna
@endsection

<div class="table-responsive">
    <table class="table" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Foto Profile</th>
                <th>User</th>
                <th>Nomor Handphone</th>
                <th>Nama Depan</th>
                <th>Nama Belakang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logins as $login)
            <tr>
                <td><img class="img-profile rounded-circle" src="{{ $login->profileImage ? asset('storage/' . $login->profileImage->image_path) :
                asset('storage/default_profile.png') }}" style="width: 40px; height: 40px; border-radius: 50px; object-fit: cover;"></td>
                <td>{{ $login->user }}</td>
                <td>{{ $login->nomor_handphone }}</td>
                <td>{{ $login->namadepan }}</td>
                <td>{{ $login->namabelakang }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection