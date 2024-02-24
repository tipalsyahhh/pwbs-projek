@extends('layout.admin')

@section('judul')
    Daftar Status
@endsection

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .profile-image {
            width: 100px;
            height: 50px;
        }

        .button-postingan {
            display: flex;
            margin-right: 10px;
        }

        .button-delete-postingan {
            margin-left: 10px;
        }
    </style>
@endpush

@section('content')

    @if (session('success'))
        <div id="success-alert" class="alert alert-primary">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Caption</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($statuses as $status)
                        <tr>
                            <td>
                                @if ($status->user)
                                    {{ $status->user->user }}
                                @else
                                    User Tidak Ditemukan
                                @endif
                            </td>
                            <td>{{ $status->caption }}</td>
                            <td>
                                <div class="button-postingan">
                                    <div class="button-delete-postingan">
                                    <form method="POST" action="{{ route('statuses.destroy', $status->id) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus status ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background-color: #2eada7; color: #fff;" data-id="{{ $status->id }}"><i class="bi bi-trash"></i></button>
                                    </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <h2>Data tidak ada</h2>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
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
                        confirmButtonColor: "#52b3d9",
                        cancelButtonColor: "#52b3d9",
                        confirmButtonText: "Ya, Hapus",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.style.display = 'none';
                            form.action = '/statuses/' + itemId;
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
        });
    </script>

    <script>
        // Ambil elemen pesan flash session
        const successAlert = document.getElementById('success-alert');

        // Cek apakah elemen pesan ada
        if (successAlert) {
            // Setelah 10 detik, sembunyikan elemen pesan
            setTimeout(function () {
                successAlert.style.display = 'none';
            }, 10000); // 10 detik
        }
    </script>
@endpush
