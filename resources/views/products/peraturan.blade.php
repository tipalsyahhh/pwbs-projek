@extends('layout.master')

@push('style')
<style>
    .card-peraturan {
        width: 100%;
        height: 100%;
        margin-top: 10px;
        margin-bottom: 10px;
        border: 1px solid #000;
        border-radius: 8px;
    }
    .isi-peraturan{
        padding: 15px;
    }
</style>
@endpush
@section('content')
<div class="card-peraturan">
    <div class="isi-peraturan">
        <h2>TATA TERTIB PENGUNJUNG PANTAI KEDU WARNA</h2>
        <ol>
            <li>
                <h4>Lingkungan Bersih:</h4>
                <p>
                    a. Jaga kebersihan pantai dengan tidak membuang sampah sembarangan.
                    Gunakan tempat sampah yang telah disediakan.
                </p>
                <p>
                    b. Bawa kantong plastik atau wadah untuk membuang sampah pribadi.
                </p>
                <p>
                    c. Hindari merokok di area pantai dan buang puntung rokok pada tempatnya.
                </p>
            </li>

            <li>
                <h4>Penggunaan Alat Transportasi:</h4>
                <p>
                    a. Parkirkan kendaraan hanya di tempat yang telah disediakan.
                </p>
                <p>
                    b. Patuhi rambu-rambu dan tanda larangan di area parkir.
                </p>
            </li>

            <li>
                <h4>Keamanan dan Keselamatan:</h4>
                <p>
                    a. Patuhi petunjuk dan peringatan yang telah dipasang oleh pihak pengelola pantai.
                </p>
                <p>
                    b. Hindari berenang di area yang dilarang atau berbahaya.
                </p>
                <p>
                    c. Patuhi instruksi petugas keamanan, untuk menjaga keselamatan.
                </p>
            </li>

            <li>
                <h4>Aktivitas Rekreasi:</h4>
                <p>
                    a. Batasi volume musik atau suara yang dapat mengganggu pengunjung lainnya.
                </p>
            </li>

            <li>
                <h4>Pentingnya Daerah Konservasi:</h4>
                <p>
                    a. Patuhi daerah yang ditetapkan sebagai kawasan konservasi atau lindung.
                    Jangan masuk ke area yang dilarang.
                </p>
                <p>
                    b. Jangan memetik atau merusak tumbuhan dan satwa liar.
                </p>
            </li>

            <li>
                <h4>Bantuan Darurat:</h4>
                <p>
                    a. Kenali lokasi tempat pertolongan pertama dan pos darurat.
                </p>
                <p>
                    b. Jika melihat kejadian darurat, segera hubungi petugas atau pihak berwenang.
                </p>
            </li>

            <li>
                <h4>Etika Sosial:</h4>
                <p>
                    a. Hormati hak dan privasi pengunjung lainnya.
                </p>
                <p>
                    b. Bersikap sopan dan ramah terhadap sesama pengunjung dan petugas pantai.
                </p>
            </li>
        </ol>

        <p>
            Dengan mengikuti tata tertib ini, pengunjung dapat bersama-sama menjaga
            kelestarian pantai dan menciptakan pengalaman yang menyenangkan bagi semua orang.
        </p>
    </div>
</div>
@endsection