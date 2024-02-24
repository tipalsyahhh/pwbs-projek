@extends('layout.master')

<link rel="stylesheet" href="{{ asset('desain/css/follow.css') }}">

@section('content')
@php
use Illuminate\Support\Facades\Auth;
@endphp
@section('content')
@php
$user = Auth::user();
@endphp

@if ($user)
@if ($user->role !== 'admin' && !App\Models\DataAkun::where('user_id', $user->id)->exists())
<p>Silakan isi profile akun anda terlebih dahulu.</p>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: "Anda Belum Mengisi Data Profile",
        text: "Silakan isi data Anda untuk melanjutkan",
        icon: "warning",
        confirmButtonColor: "#2eada7",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ route('dataAkun.create') }}";
        }
    });
</script>
@endif
@else
<h1>SELAMAT DATANG</h1>
@endif

<div class="input-market">
    <div class="input-group">
        <div class="input-group-append">
            <span class="input-group-text bg-light border-0" style="border-radius: 50px 0 0 50px;">
                <i class="fas fa-search fa-sm"></i>
            </span>
        </div>
        <input type="text" class="form-control bg-light border-0 small" id="searchMenu"
            placeholder="Cari Pengguna lain..." aria-label="Search" aria-describedby="basic-addon2"
            style="border-radius: 0 50px 50px 0;">
    </div>
</div>

@php
$filteredUsers = $allUsers->where('role', '!=', 'admin')->sortByDesc('created_at')->take(5);
@endphp

@foreach ($filteredUsers as $userItem)
    <a href="{{ route('follow.profile', ['userId' => $userItem->id]) }}">
        <div class="card-user follow-item" data-searchable="{{ strtolower($userItem->user) }}">
            <div class="col-md-4 mb-4">
                <div class="profile-isi">
                    <img class="profile-image"
                        src="{{ isset($userItem->profileImage) ? asset('storage/' . $userItem->profileImage->image_path) : asset('storage/default_profile.png') }}"
                        alt="Profile Image" data-toggle="modal" data-target="#profile-modal">
                    <div class="profile-name">
                        <p style="color: #333; margin-bottom: 5px; font-weight: bold;">{{ $userItem->user }}</p>
                        <p style="color: #878585; margin-bottom: 5px;">{{ optional($userItem->dataAkun)->nama_depan }} {{ optional($userItem->dataAkun)->nama_belakang }}</p>
                    </div>
                </div>
            </div>
        </div>
    </a>
@endforeach

    @php
        // Data yang tidak ditampilkan
        $hiddenUsers = $allUsers->where('role', '!=', 'admin')->sortByDesc('created_at')->skip(5);
    @endphp

    @foreach ($hiddenUsers as $hiddenUser)
        <a href="{{ route('follow.profile', ['userId' => $hiddenUser->id]) }}">
            <div class="hidden-data" data-searchable="{{ strtolower($hiddenUser->user) }}" style="display: none;">
                <div class="card-user">
                    <div class="profile-isi">
                        <img class="profile-image"
                            src="{{ isset($hiddenUser->profileImage) ? asset('storage/' . $hiddenUser->profileImage->image_path) : asset('storage/default_profile.png') }}"
                            alt="Profile Image" data-toggle="modal" data-target="#profile-modal">
                        <div class="profile-name" style="color: #333;">
                            <p style="color: #333; margin-bottom: 5px; font-weight: bold;">{{ $hiddenUser->user }}</p>
                            <p style="color: #878585; margin-bottom: 5px;">{{ optional($hiddenUser->dataAkun)->nama_depan }} {{ optional($hiddenUser->dataAkun)->nama_belakang }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach

    <div id="noResultsMessage" style="display: none; color: #333; font-weight: bold;">
        <center>Pengguna tidak ditemukan</center>
    </div>

<div class="modal fade" id="profile-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="" id="modal-image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
    const searchMenuInput = document.getElementById('searchMenu');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const allItems = document.querySelectorAll('.follow-item, .hidden-data');
    const originalDisplayStatus = Array.from(allItems).map(item => item.style.display);

    searchMenuInput.addEventListener('input', function () {
        const keyword = searchMenuInput.value.toLowerCase();
        let resultsFound = false;

        allItems.forEach(function (item, index) {
            const searchableContent = item.getAttribute('data-searchable');

            if (searchableContent.toLowerCase().includes(keyword)) {
                item.style.display = 'block';
                resultsFound = true;
            } else {
                item.style.display = 'none';
            }
        });

        if (!resultsFound) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    });

    searchMenuInput.addEventListener('keyup', function () {
        if (searchMenuInput.value.trim() === '') {
            allItems.forEach(function (item, index) {
                item.style.display = originalDisplayStatus[index];
            });
            noResultsMessage.style.display = 'none';
        }
    });
    const profileImages = document.querySelectorAll('.profile-image');
    const modalImage = document.getElementById('modal-image');
    profileImages.forEach(image => {
        image.addEventListener('click', function () {
            const imgSrc = image.getAttribute('src');
            modalImage.setAttribute('src', imgSrc);
        });
    });
</script>
@endsection