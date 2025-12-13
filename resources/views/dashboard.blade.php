{{-- resources/views/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin Inventaris') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- KARTU STATISTIK UTAMA --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                {{-- Kartu 1: Total Produk --}}
                <div class="bg-white dark:bg-gray-800 p-6 shadow-xl rounded-lg border-l-4 border-indigo-500 dark:border-indigo-400">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Jenis Produk</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $totalProducts }}</div>
                    <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-2">
                        <a href="{{ route('products.index') }}">Lihat semua data &rarr;</a>
                    </p>
                </div>

                {{-- Kartu 2: Total Stok Global --}}
                <div class="bg-white dark:bg-gray-800 p-6 shadow-xl rounded-lg border-l-4 border-green-500 dark:border-green-400">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Semua Stok Barang</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ number_format($totalStock) }} unit</div>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                        Statistik gabungan dari semua produk.
                    </p>
                </div>

                {{-- Kartu 3: Link Cepat Tambah Produk --}}
                <div class="bg-indigo-600 p-6 shadow-xl rounded-lg text-white">
                    <div class="text-sm font-medium">Aksi Cepat</div>
                    <div class="text-xl font-bold mt-2">
                        <a href="{{ route('products.create') }}">
                            + Tambah Produk Baru
                        </a>
                    </div>
                    <p class="text-xs mt-2 opacity-80">
                        Kelola stok atau harga produk yang sudah ada.
                    </p>
                </div>
            </div>
            
            {{-- NOTIFIKASI STOK RENDAH --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4 border-b pb-2 text-red-600 dark:text-red-400">⚠️ Notifikasi Stok Rendah (< 10 Unit)</h3>
                    
                    @if ($lowStockProducts->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">Semua stok produk berada pada level yang aman. Bagus!</p>
                    @else
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($lowStockProducts as $product)
                                <li class="py-3 flex justify-between items-center">
                                    <span class="font-medium">{{ $product->name }}</span>
                                    <div class="text-sm text-red-600 dark:text-red-400">
                                        Stok Sisa: **{{ $product->stock }}** (<a href="{{ route('products.edit', $product->id) }}" class="underline hover:text-red-800">Edit/Restock</a>)
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>