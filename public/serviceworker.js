const CACHE_NAME = 'inventaris-uas-v3'; // Saya naikkan versinya ke v3 biar fresh
const CORE_URLS = [
    '/',
    '/login',
    '/products',
];

// Fungsi untuk mendapatkan aset (DENGAN PENGAMAN ERROR)
async function getViteAssets() {
    try {
        // Coba ambil manifest build
        const response = await fetch('/build/manifest.json');
        
        // Jika file tidak ada (misal mode dev atau belum build), lempar error
        if (!response.ok) {
            throw new Error('Manifest build belum tersedia (Mode Dev)');
        }

        const manifest = await response.json();
        const assetPaths = Object.values(manifest).map(entry => '/build/' + entry.file);
        
        // Jika sukses, gabungkan URL Inti + Aset Build
        return [...CORE_URLS, ...assetPaths];

    } catch (error) {
        // INI PERBAIKANNYA:
        // Jika gagal (lagi ngoding di localhost), jangan error.
        // Cukup kembalikan halaman inti saja supaya PWA tetap jalan.
        console.warn('PWA berjalan di mode Dev. Hanya meng-cache halaman inti.');
        return CORE_URLS; 
    }
}

// Install event
self.addEventListener('install', event => {
    // Paksa SW baru untuk segera aktif tanpa menunggu tab ditutup
    self.skipWaiting();

    event.waitUntil(
        getViteAssets().then(urlsToCache => {
            return caches.open(CACHE_NAME).then(cache => {
                console.log('Opened cache. Caching ' + urlsToCache.length + ' assets.');
                return cache.addAll(urlsToCache);
            });
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