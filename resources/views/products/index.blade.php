@extends($user && $user->role === 'admin' ? 'layout.admin' : 'layout.master')

@section('judul')
@if ($user && $user->role === 'admin')
Daftar Pemesanan
@else
Struk Pembayaran
@endif
@endsection

<head>
    <link rel="stylesheet" href="{{ asset('desain/css/struk.css') }}">
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

@section('content')
<div class="card">
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-primary">
            {{ session('success') }}
        </div>
        @endif

        @if ($user && $user->role === 'admin')
        <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Pesanan</th>
                        <th>User</th>
                        <th>Alamat</th>
                        <th>Jumlah Beli</th>
                        <th>Total Harga</th>
                        <th>Waktu Pemesanan</th>
                        <th>Kedatangan</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->postingan->nama_menu }}</td>
                        <td>{{ $product->login->user }}</td>
                        <td>{{ $product->alamat->alamat }}</td>
                        <td>{{ $product->jumlah_beli }}</td>
                        <td>{{ $product->total_harga }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>{{ $product->tanggal_datang }}</td>
                        <td>{{ $product->status }}</td>
                        <td>
                            <div class="d-flex">
                                <form method="POST" action="{{ route('approve.order') }}" class="mr-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-warning"><i
                                            class="bi bi-check-all"></i></button>
                                </form>

                                <form action="{{ route('products.rejectOrder') }}" method="POST" class="mr-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-warning"><i
                                            class="bi bi-x-circle"></i></button>
                                </form>

                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-warning"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        {{-- Tampilan struk pembayaran --}}
        @foreach ($products as $product)
        <div class="card-struk">
            <center>
                <div class="centang">
                    <i class="bi bi-check-lg" style="font-size: 1.7em;"></i>
                </div>
                <h4>Pemesanan Berhasil</h4>
                <p style="margin-top: -5px;">Status pesanan anda {{$product->status}}</p>
                <p style="margin-top: -5px;">Pemesan :</p>
                <p style="margin-top: -15px;">{{$user->user}}</p>
                <h2>Rp {{ number_format($product->total_harga, 0, ',', '.') }}</h2>
            </center>
            <h5>Detail Transaksi</h5>
            <div class="detail-struk">
                <p>Nama Toko :</p>
                <p>
                    {{ optional($product->postingan->user->datatoko)->nama_depan }}
                    {{ optional($product->postingan->user->datatoko)->nama_belakang }}
                </p>
            </div>
            <div class="detail-struk">
                <p>Nama Product :</p>
                <p>
                    {{$product->postingan->nama_menu}}
                </p>
            </div>
            <div class="detail-struk">
                <p>Harga Peritem :</p>
                <p>
                    Rp {{ number_format($product->postingan->harga, 0, ',', '.') }}
                </p>
            </div>
            <div class="detail-struk">
                <p>Jumlah Pesan :</p>
                <p>
                    {{$product->jumlah_beli}}
                </p>
            </div>
            <div class="detail-struk">
                <p>Waktu Pesan :</p>
                <p>
                    {{$product->created_at}}
                </p>
            </div>
            <div class="detail-struk" style="color: #2eada7; font-weight: bold;">
                <h5 style="font-weight: bold;">Total Harga :</h5>
                <h5 style="font-weight: bold;">
                    Rp {{ number_format($product->total_harga, 0, ',', '.') }}
                </h5>
            </div>
        </div>
        <div class="struk-button">
            <a href="{{ route('pages.welcome') }}" style="text-decoration: none;">Back to home</a>
        </div>
        @endforeach
        @endif
    </div>
</div>

@endsection