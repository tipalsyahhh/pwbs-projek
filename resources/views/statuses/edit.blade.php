@extends('layout.master')

@section('judul')
    Edit Status
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
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
        border-radius: 15px;
        border: 1px solid #5fc987;
        background-color: #5fc987;
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
<form id="update-form" method="post" action="{{ route('statuses.update', ['id' => $status->id]) }}" enctype="multipart/form-data">

    @if(session('success'))
    <div id="success-alert" class="alert alert-warning">
        {{ session('success') }}
    </div>
    @endif
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="caption" style="color: #333; font-weight: bold;">Caption</label>
        <textarea name="caption" id="caption" class="form-control">{{ $status->caption }}</textarea>
    </div>

    @error('caption')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

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
        <p style="color: black;">Pilih image status anda lagi</p>
        <button id="showImageStatusButton"><i class="bi bi-images" style="font-size: 1.5rem;"></i></button>
        <button id="closeImageStatusButton"><i class="bi bi-x" style="font-size: 1.5rem;"></i></button>
    </div>

    @error('image')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <button type="button" class="button" id="btn-update"><i class="bi bi-pencil-square"></i> Simpan</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btn-update').addEventListener('click', function () {
        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah Anda ingin menyimpan perubahan?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#5fc987",
            cancelButtonColor: "#5fc987",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('update-form').submit();
            }
        });
    });
});
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 10000);
    }
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

                    readAndDisplayImage(index + 1);
                };

                reader.onerror = function (error) {
                    console.error('Error reading image:', error);
                    readAndDisplayImage(index + 1);
                };

                reader.readAsDataURL(input.files[index]);
            }
        }

        readAndDisplayImage(0);
    }
</script>
@endsection
