@extends('layout.master')

@section('judul')
    Riwayat Perubahan Cast
@endsection

@push('style')
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

@section('content')
        <div class="col-md-12">
            <h2>Riwayat Perubahan Cast</h2>
            <table class="table" id="historyTable">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Bio</th>
                        <th>Action</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history_casts as $key => $history_cast)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $history_cast->nama }}</td>
                            <td>{{ $history_cast->umur }}</td>
                            <td>{{ $history_cast->bio }}</td>
                            <td>{{ $history_cast->action }}</td>
                            <td>{{ \Carbon\Carbon::parse($history_cast->time)->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection

@push('script')
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#historyTable').DataTable();
    });
</script>
@endpush
