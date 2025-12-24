const CACHE_NAME = 'inventaris-uas-v4'; // Saya naikkan ke v4 biar browser sadar ada update
const CORE_URLS = [
    '/',
    '/login',
    '/products',
];

// --- BAGIAN INI TIDAK SAYA UBAH (TETAP SAMA) ---
async function getViteAssets() {
    try {
        const response = await fetch('/build/manifest.json');
        if (!response.ok) {
            throw new Error('Manifest build belum tersedia (Mode Dev)');
        }
        const manifest = await response.json();
        const assetPaths = Object.values(manifest).map(entry => '/build/' + entry.file);
        return [...CORE_URLS, ...assetPaths];
    } catch (error) {
        console.warn('PWA berjalan di mode Dev. Hanya meng-cache halaman inti.');
        return CORE_URLS; 
    }
}

// --- BAGIAN INSTALL & ACTIVATE TIDAK SAYA UBAH ---
self.addEventListener('install', event => {
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

// --- BAGIAN INI YANG SAYA PERBAIKI (SOLUSI DARI ERROR TADI) ---
// Strategi diubah jadi: Network First (Cek Internet dulu -> Baru Cache)
// Ini aman untuk Laravel supaya data tidak nyangkut/error.
self.addEventListener('fetch', event => {
    event.respondWith(
        fetch(event.request)
            .then(response => {
                // 1. Kalau Internet Lancar: Kembalikan respon asli
                // Dan simpan salinannya ke cache (update cache otomatis)
                if (!response || response.status !== 200 || response.type !== 'basic') {
                    return response;
                }
                const responseToCache = response.clone();
                caches.open(CACHE_NAME)
                    .then(cache => {
                        cache.put(event.request, responseToCache);
                    });
                return response;
            })
            .catch(() => {
                // 2. Kalau Internet Mati (OFFLINE): Baru ambil dari Cache
                // Ini mencegah error saat reload page
                return caches.match(event.request);
            })
    );
});