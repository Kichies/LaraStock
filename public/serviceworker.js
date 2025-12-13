const CACHE_NAME = 'inventaris-uas-v2'; // Ganti versi cache agar browser menginstal ulang
    
// Daftar halaman wajib
const CORE_URLS = [
    '/',
    '/login',
    '/products', // Akses halaman produk setelah login
];

// Fungsi untuk mendapatkan semua aset dari manifest Vite
async function getViteAssets() {
    // Membaca manifest yang dibuat oleh NPM RUN BUILD
    const response = await fetch('/build/manifest.json');
    const manifest = await response.json();
    
    // Mengekstrak path asset yang benar (sudah di-hash)
    const assetPaths = Object.values(manifest).map(entry => '/build/' + entry.file);
    
    return [...CORE_URLS, ...assetPaths];
}

// Install event - Caching assets
self.addEventListener('install', event => {
    event.waitUntil(
        getViteAssets().then(urlsToCache => {
            return caches.open(CACHE_NAME).then(cache => {
                console.log('Opened cache. Caching ' + urlsToCache.length + ' assets.');
                return cache.addAll(urlsToCache); // Cache semua aset yang benar
            });
        }).catch(error => {
             console.error('Failed to cache assets:', error);
        })
    );
});

// Activate event - Menghapus cache lama
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.filter(cacheName => {
                    return cacheName.startsWith('inventaris-uas-') && cacheName !== CACHE_NAME;
                }).map(cacheName => {
                    return caches.delete(cacheName);
                })
            );
        })
    );
});

// Fetch event - Strategy Cache First
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request).then(response => {
            if (response) {
                return response;
            }
            return fetch(event.request);
        })
    );
});