@extends('layout.master')


<style>
    .create-status {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
    }

    h3.create-status {
        color: #333;
        margin-top: 8px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
        font-weight: bold;
    }

    .user-postingan {
        display: flex;
        align-items: center;
    }

    .img-profile {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .user-postingan p {
        margin: 0;
        color: #333;
        font-weight: bold;
    }

    .button-image {
        border: 1px solid #ccc;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 10px;
        margin-bottom: 20px;
        width: 100%;
    }

    .image-status {
        visibility: hidden;
    }

    #closeImageStatusButton {
        display: none;
    }

    .image-status {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        width: 100%;
        margin-bottom: 10px;
        text-align: center;
        margin-top: 10px;
        position: relative;
    }

    .image-status label {
        display: block;
        margin-bottom: 10px;
    }

    .image-status input {
        padding: 8px;
        box-sizing: border-box;
    }

    .selected-image {
        max-width: 100%;
        margin-top: 10px;
    }

    .selected-img {
        width: 100%;
        height: auto;
        margin-bottom: 8px;
    }

    .button {
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

    .button-image p {
        color: black;
        font-weight: bold;
    }

    .button-image button {
        border: none;
        background-color: transparent;
        cursor: pointer;
        color: #08885d;
    }

    .visually-hidden {
        position: absolute !important;
        height: 1px;
        width: 1px;
        overflow: hidden;
        clip: rect(1px, 1px, 1px, 1px);
        white-space: nowrap;
    }
</style>
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

<div class="judul-status">
    <h3 class="create-status">Buat postingan</h3>
</div>
<div class="user-postingan">
    <img class="img-profile rounded-circle"
        src="{{ $user->profileImage ? asset('storage/' . $user->profileImage->image_path) : asset('storage/default_profile.png') }}"
        style="width: 40px; height: 40px; margin-top:10px; object-fit: cover;">
    <p>{{ $user->user }}</p>
</div>
<form action="{{ route('statuses.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-caption">
        <textarea name="caption" class="form-control" placeholder="Apa yang Anda pikirkan, @if($user->dataakun) {{ $user->dataakun->nama_depan }} ? @else {{ $user->namadepan }} ? @endif" style="border: none; border-radius: 0; margin-left: -7px; margin-top: 15px; position: relative;" required></textarea>
    </div>
    <div class="image-status">
        <label for="imageInput" style="cursor: pointer;">
            <i class="bi bi-file-earmark-image-fill" style="font-size: 2rem; color: green;"></i>
        </label>
        <span>Tambahkan Foto</span>
        <input type="file" name="image[]" id="imageInput" class="form-control-file visually-hidden" required multiple
            onchange="displayImages()">
        <div id="selectedImage" class="selected-image"></div>
    </div>
    <div class="button-image">
        <p style="color: #333;">Tambahkan ke postingan anda</p>
        <button id="showImageStatusButton"><i class="bi bi-images" style="font-size: 1.5rem;"></i></button>
        <button id="closeImageStatusButton"><i class="bi bi-x" style="font-size: 1.5rem;"></i></button>
    </div>

    <button type="submit" class="button" style="width: 100%;">Create Status</button>
</form>

<script>
    var showButton = document.getElementById('showImageStatusButton');
    var closeButton = document.getElementById('closeImageStatusButton');
    var imageStatusDiv = document.querySelector('.image-status');

    showButton.addEventListener('click', function () {
        imageStatusDiv.style.visibility = 'visible';
        showButton.style.display = 'none';
        closeButton.style.display = 'block';
    });

    closeButton.addEventListener('click', function () {
        imageStatusDiv.style.visibility = 'hidden';
        showButton.style.display = 'block';
        closeButton.style.display = 'none';
    });

    function displayImages() {
        var input = document.getElementById('imageInput');
        var selectedImageDiv = document.getElementById('selectedImage');

        // Clear previous images
        selectedImageDiv.innerHTML = '';

        function readAndDisplayImage(index) {
            if (index < input.files.length) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Selected Image';
                    img.className = 'selected-img';
                    selectedImageDiv.appendChild(img);

                    // Recursively call the next image
                    readAndDisplayImage(index + 1);
                };

                reader.onerror = function (error) {
                    console.error('Error reading image:', error);
                    // Recursively call the next image
                    readAndDisplayImage(index + 1);
                };

                reader.readAsDataURL(input.files[index]);
            }
        }

        // Start the recursive process with the first image
        readAndDisplayImage(0);
    }
</script>
@endsection