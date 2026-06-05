const CACHE_NAME = 'melodiyam-v1';
const OFFLINE_URL = '/';

const PRECACHE_ASSETS = [
    '/',
];

// Install — precache shell
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => cache.addAll(PRECACHE_ASSETS))
    );
    self.skipWaiting();
});

// Activate — clean old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k))
            )
        )
    );
    self.clients.claim();
});

// Fetch — network first, fallback to cache
self.addEventListener('fetch', event => {
    // Skip non-GET requests
    if (event.request.method !== 'GET') return;

    // Skip Livewire, API, and admin requests
    const url = new URL(event.request.url);
    if (url.pathname.startsWith('/livewire') ||
        url.pathname.startsWith('/api') ||
        url.pathname.startsWith('/admin') ||
        url.searchParams.has('_wire')) {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then(response => {
                // Cache successful GET responses
                if (response.status === 200) {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request, clone);
                    });
                }
                return response;
            })
            .catch(() => {
                // Offline — serve from cache
                return caches.match(event.request).then(cached => {
                    if (cached) return cached;
                    // For navigation, return offline page
                    if (event.request.mode === 'navigate') {
                        return caches.match(OFFLINE_URL);
                    }
                    return new Response('', { status: 408 });
                });
            })
    );
});
