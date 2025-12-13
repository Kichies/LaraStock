<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id(); 
        // --- START: KOLOM INVENTARIS ---
        $table->string('name')->unique();        // Nama produk (wajib, harus unik)
        $table->string('sku')->nullable();       // Kode unik produk/SKU (opsional)
        $table->integer('stock')->default(0);    // Jumlah stok saat ini (int, default 0)
        $table->decimal('price', 10, 2);         // Harga produk (10 digit total, 2 di belakang koma)
        $table->text('description')->nullable(); // Deskripsi produk (opsional)
        // --- END: KOLOM INVENTARIS ---
        $table->timestamps(); // created_at dan updated_at
    });
}


    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
