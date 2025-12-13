<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // PENTING: Untuk validasi unik

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name', 
            'sku' => 'nullable|string|max:100', 
            'stock' => 'required|integer|min:0', 
            'price' => 'required|numeric|min:0', 
            'description' => 'nullable|string', 
        ]);
        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function show(string $id) { /* */ }

    /**
     * Show the form for editing the specified resource (Menampilkan Form Edit).
     */
    public function edit(string $id)
    {
        // Cari produk yang akan diedit
        $product = Product::findOrFail($id);

        // Kirim data produk tersebut ke View edit.blade.php
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage (Memperbarui Data Produk).
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        // VALIDASI: Menggunakan Rule::unique untuk MENGECUALIKAN ID produk saat ini
        $validated = $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('products')->ignore($product->id),
            ],
            'sku' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // PERBARUI DATA
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk ' . $product->name . ' berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk ' . $product->name . ' berhasil dihapus.');
    }
}