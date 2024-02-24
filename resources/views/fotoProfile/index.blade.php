@extends('layout.master')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .card-foto-profile {
        width: 100%;
        border: 1px solid #ddd;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-top: 20px;
    }

    .foto-frofile-akun {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .profile-image {
        border-radius: 50%;
        width: 200px;
        height: 200px;
        cursor: pointer;
        object-fit: cover;
        margin-right: 10px;
    }

    #profile-modal img {
        max-width: 100%;
        max-height: 100%;
    }

    .button-pp {
        position: absolute;
        bottom: 0;
        margin-left: 80px;
    }
</style>
@endpush

@section('content')
@forelse ($fotoProfiles as $key => $fotoProfile)
<div class="card-foto-profile">
    <div class="foto-frofile-akun">
        <img class="profile-image" src="{{ asset('storage/' . $fotoProfile->image_path) }}" alt="Profile Image"
            data-toggle="modal" data-target="#profile-modal">
        <div class="button-pp">
            <button type="button" class="btn" style="background-color: #2eada7; color: white;" data-toggle="modal" data-target="#exampleModal">
                <i class="bi bi-gear-fill"></i>
            </button>
        </div>
    </div>
    @if(session('success'))
    <div id="success-alert" class="alert alert-warning" style="margin-top: 15px;">
        {{ session('success') }}
    </div>
    @endif
    <center>
        <h3 style="color: black; margin-top: 15px;">Foto profile setting</h3>
    </center>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; background-color: #3a3a39">
            <div class="modal-body text-center">
                <a href="{{ route('foto-profile.edit', ['user_id' => $fotoProfile->user_id]) }}"
                    class="btn btn-sm" style="border:none; color:white;">Ubah Foto</a>
                <hr class="my-2" style="background-color: #fff;">
                <form method="POST"
                    action="{{ route('foto-profile.destroy', ['foto_profile' => $fotoProfile->user_id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-delete"
                        data-id="{{ $fotoProfile->user_id }}" style="border:none; color:white;">Hapus</button>
                </form>
                <hr class="my-2" style="background-color: #fff;">
                <button type="button" class="btn" data-dismiss="modal" style="border:none; color:white;">Tutup</button>
            </div>
        </div>
    </div>
</div>
@empty
<div class="card-foto-profile">
    <div class="foto-frofile-akun">
        <div class="foto-frofile-akun">
            <img class="profile-image" src="{{ asset('storage/default_profile.png') }}" alt="Profile Image"
                data-toggle="modal" data-target="#profile-modal">
            <div class="button-pp">
                @if ($fotoProfiles->isEmpty())
                <a class="btn" style="background-color: #2eada7; color: white;"
                    href="{{ route('foto-profile.create') }}"><i class="bi bi-camera"></i></a>
                @endif
            </div>
        </div>
    </div>
    <center>
        <h3 style="color: black; margin-top: 15px;">Tambahkan foto profile anda</h3>
    </center>
</div>
@endforelse

<div class="modal fade" id="profile-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="" alt="Profile Image">
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#example1').DataTable();

        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const itemId = button.getAttribute('data-id');
                Swal.fire({
                    title: "Konfirmasi",
                    text: "Apakah Anda ingin menghapus data ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#2eada7",
                    cancelButtonColor: "#2eada7",
                    confirmButtonText: "Ya, Hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/foto-profile/' + itemId;
                        form.style.display = 'none';
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const csrfInput = document.createElement('input');
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;
                        form.appendChild(csrfInput);
                        const methodInput = document.createElement('input');
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        form.appendChild(methodInput);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
        const profileImages = document.querySelectorAll('.profile-image');
        profileImages.forEach(image => {
            image.addEventListener('click', function () {
                const imgSrc = image.getAttribute('src');
                $('#profile-modal img').attr('src', imgSrc);
            });
        });
    });
    const successAlert = document.getElementById('success-alert');

        if (successAlert) {
            setTimeout(function () {
                successAlert.style.display = 'none';
            }, 10000);
        }
</script>
@endpush