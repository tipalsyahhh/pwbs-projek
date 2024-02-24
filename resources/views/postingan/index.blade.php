@extends($user && $user->role === 'admin' ? 'layout.admin' : 'layout.master')

@php
use Illuminate\Support\Facades\Auth;
@endphp

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .foouter-postingan {
        width: 100%;
        height: 250px;
        padding: 10px;
        margin-top: 70px;
        background-image: url('../../img/contoh.gif');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .card-judul {
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.49);
        padding: 10px;
        margin-top: 120px;
        transform: translateY(-50%);
        background-color: #fff;
    }

    .card-judul h4 {
        font-weight: bold;
        color: #2eada7;
    }

    .user-postingan {
        display: flex;
        align-items: center;
        color: #333;
        margin-left: 10px;
    }

    .user-postingan img {
        width: 60px;
        height: 60px;
        border-radius: 50px;
        margin-right: 15px;
        object-fit: cover;
    }

    .button-tambah {
        align-items: center;
        width: 100%;
        margin-top: 20px;
        border-radius: 50px;
        border: 1px solid #fff;
        background-color: #2eada7;
        height: 40px;
        display: flex;
        justify-content: center;
        font-weight: bold;
        font-size: 20px;
        cursor: pointer;
    }

    .info {
        color: #333;
        margin-top: -40px;
    }

    .card-isi {
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.49);
        padding: 10px;
        margin-bottom: 20px;
    }

    .isi {
        width: 100%;
        display: flex;
        align-items: center;
        color: #333;
    }

    .image-isi {
        width: 30%;
        margin-right: 10px;
    }

    .image-isi img {
        width: 100%;
    }

    .button-postingan {
        display: flex;
        margin-left: auto;
        margin-right: 20px;
        align-items: stretch;
    }

    .edit {
        margin-left: 5px;
    }

    .button-delete-postingan {
        margin-left: 10px;
    }

    .description {
        margin-bottom: 10px;
    }

    .description .desktop-text {
        display: none;
    }

    .description .mobile-text {
        display: inline;
    }

    .detail-product {
        color: #333;
        margin: none;
    }

    @media screen and (max-width: 768px) {
        .description .desktop-text {
            display: none;
        }

        .description .mobile-text {
            display: inline;
        }
    }

    @media screen and (min-width: 769px) {
        .description .desktop-text {
            display: inline;
        }

        .description .mobile-text {
            display: none;
        }
    }
</style>
@endpush

@if(Auth::check() && Auth::user()->role !== 'admin')
    
@endif

@section('content')
@if (session('success'))
<div id="success-alert" class="alert alert-primary">
    {{ session('success') }}
</div>
@endif
@if ($user && $user->role === 'admin')
@section('judul')
    Daftar Product
@endsection
<div class="table-responsive">
    <table class="table" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Harga</th>
                <th scope="col">Deskripsi</th>
                <th scope="col">Jenis</th>
                <th scope="col">Kapasitas</th>
                <th scope="col">Terjual</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($postingan as $post)
            <tr>
                <td>{{ $post->nama_menu }}</td>
                <td>{{ $post->harga }}</td>
                <td>{{ $post->deskripsi }}</td>
                <td>{{ $post->jenis }}</td>
                <td>{{ substr($post->deskripsi, 0, 50) }}</td>
                <td>{{ $jumlahBeli[$post->id] }}</td>
                <td>
                    <div class="button-postingan">
                        <div class="button-delete-postingan">
                            <form method="POST" action="{{ route('postingan.destroy', ['id' => $post->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background-color: #2eada7; color: #fff;" data-id="{{ $post->id }}"><i
                                        class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <h2>Data tidak ada</h2>
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>
</div>
@else
<div class="card-judul">
    <center>
        <h4>Product Toko Mu</h4>
    </center>
    <div class="user-postingan">
        <img class="img-profile rounded-circle"
            src="{{ $user->profileImage ? asset('storage/' . $user->profileImage->image_path) : asset('storage/default_profile.png') }}">
        <div class="detail-produk">
            @foreach ($datatoko as $datatoko)
            @if (Auth::user()->role === 'admin' || $datatoko->user_id === Auth::user()->id)
            <p style="margin-bottom: 5px;">{{ auth()->user()->datatoko->nama_depan }} {{
                auth()->user()->datatoko->nama_belakang }}</p>
            <p style="margin-bottom: 5px">{{ auth()->user()->datatoko->alamat }}</p>
            @break
            @endif
            @endforeach
        </div>
    </div>
    <div class="button-tambah">
        <a href="{{ route('postingan.create') }}" style="text-decoration: none;"><i class="bi bi-plus"></i> Tambah
            Data</a>
    </div>
</div>
<div class="info">
    <p>! Jika anda merubah jumlah product maka harus menambahkan jumlah berdasarkan jumlah awal yang anda buat</p>
    <p>Jika awal jumlah product anda adalah 200 maka tambahkan jumlah dari jumlah awal product anda</p>
</div>


@forelse ($postingan as $post)
@if (Auth::user()->role === 'admin' || $post->user_id === Auth::user()->id)
<div class="card-isi">
    <div class="isi">
        <div class="image-isi">
            @if ($post->image)
            @php
            $imagePaths = explode(',', $post->image);
            $firstImagePath = trim($imagePaths[0]);
            @endphp
            <img src="{{ asset($firstImagePath) }}" alt="Gambar Postingan">
            @else
            <p>Tidak ada gambar yang tersedia.</p>
            @endif
        </div>
        <div class="deskripsi">
            <p class="description">
                <span class="desktop-text">{{ substr($post->deskripsi, 0, 90) }}</span>
                <span class="mobile-text">{{ substr($post->deskripsi, 0, 20) }}</span>...
            </p>
        </div>
        <div class="button-postingan">
            <div class="edit">
                <a href="{{ route('postingan.edit', ['id' => $post->id]) }}" class="btn"
                    style="background-color: #2eada7; color: #fff;"><i class="bi bi-pencil"></i></a>
            </div>
            <div class="button-delete-postingan">
                <form method="POST" action="{{ route('postingan.destroy', ['id' => $post->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background-color: #2eada7; color: #fff;"
                        data-id="{{ $post->id }}"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    <div class="detail-product">
        <p style="margin-bottom: 5px; margin-top: 10px;">Nama product : {{ $post->nama_menu }}</p>
        <p style="margin-bottom: 5px;">Rp {{ number_format($post->harga, 0, ',', '.') }}</p>
        <p style="margin-bottom: 5px;">Jenis Product : {{ $post->jenis }}</p>
        @php
        $jumlahBeli = $post->products->where('status', 'disetujui')->sum('jumlah_beli');
        $sisaKapasitas = $post->kapasitas - $jumlahBeli;
        @endphp
        <p style="font-weight: bold;">Jumlah ketersediaan : {{$sisaKapasitas}}</p>
    </div>
</div>
@endif
@endforeach
@endif

@endsection

@push('script')
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable();

        const deleteButtons = document.querySelectorAll('.button-delete-postingan button');
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
                        form.action = '/postingan/' + itemId;
                        form.style.display = 'none';
                        const csrfToken = document.querySelector(
                            'meta[name="csrf-token"]').getAttribute('content');
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
    });
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(function () {
            successAlert.style.display = 'none';
        }, 10000);
    }
</script>
@endpush