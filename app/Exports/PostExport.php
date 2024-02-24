<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Product;

class PostExport implements FromCollection
{
    public function collection()
    {
        return Product::all(); // Mengambil semua data postingan dari model Post
    }
}