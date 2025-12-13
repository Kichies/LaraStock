{{-- File: resources/views/products/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Produk: ' . $product->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Form untuk Update (Pembaruan) --}}
                    {{-- action mengarah ke products.update dengan membawa ID produk --}}
                    <form method="POST" action="{{ route('products.update', $product->id) }}">
                        @csrf 
                        @method('PATCH') {{-- Wajib: Method Spoofing untuk operasi UPDATE --}}

                        {{-- 1. Input Nama Produk --}}
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Produk')" />
                            {{-- Nilai diambil dari $product->name atau old('name') jika gagal validasi --}}
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- 2. Input SKU (Kode Produk) --}}
                        <div class="mb-4">
                            <x-input-label for="sku" :value="__('SKU / Kode Produk (Opsional)')" />
                            <x-text-input id="sku" class="block mt-1 w-full" type="text" name="sku" :value="old('sku', $product->sku)" />
                            <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- 3. Input Stok --}}
                            <div class="mb-4">
                                <x-input-label for="stock" :value="__('Jumlah Stok')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock', $product->stock)" required min="0" />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>

                            {{-- 4. Input Harga --}}
                            <div class="mb-4">
                                <x-input-label for="price" :value="__('Harga Jual (Rp)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="any" name="price" :value="old('price', $product->price)" required min="0" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                        </div>
                        
                        {{-- 5. Input Deskripsi --}}
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi Produk (Opsional)')" />
                            <textarea id="description" name="description" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="flex justify-end mt-6">
                            <x-secondary-button x-on:click.prevent="$dispatch('close')">
                                <a href="{{ route('products.index') }}">{{ __('Batal') }}</a>
                            </x-secondary-button>
                            
                            <x-primary-button class="ms-3">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>