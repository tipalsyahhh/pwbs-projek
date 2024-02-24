<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PostExport; // Ganti dengan nama class ekspor yang sesuai
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;

class ExcelExportController extends Controller
{
    public function export()
    {
        return Excel::download(new PostExport, 'penjualan.xlsx'); // Ganti dengan nama file Excel yang Anda inginkan
    }
}
