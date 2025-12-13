<?php

namespace App\Http\Controllers;

use App\Models\Product; // Ambil Model Produk
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil statistik yang relevan
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        
        // Ambil 5 produk dengan stok terendah (Notifikasi)
        $lowStockProducts = Product::where('stock', '<', 10) 
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();
        
        // Kirim data ke View dashboard
        return view('dashboard', [
            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}