<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product; // Menggunakan Model yang sama
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response; // Tambahkan ini jika ingin menggunakan Response::json()

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource (Menampilkan Daftar Produk sebagai JSON).
     */
    public function index()
    {
        // Ambil semua data produk
        $products = Product::all();

        // Kembalikan data dalam format JSON
        return Response::json([
            'status' => 'success',
            'message' => 'Data inventaris berhasil diambil',
            'data' => $products
        ], 200);
    }
    
    // Fungsi store, show, update, destroy, dll. biarkan kosong atau hapus jika tidak digunakan
}