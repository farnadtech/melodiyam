const CACHE_NAME = 'melodiyam-v2';
const OFFLINE_URL = './';

// Install — skip waiting, activate immediately
self.addEventListener('install', event => {
    self.skipWaiting();
});

// Activate — clean old caches, claim all clients
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

// Fetch — network only (no caching to avoid PWA issues)
self.addEventListener('fetch', event => {
    // Skip non-GET requests
    if (event.request.method !== 'GET') return;

    // Skip Livewire, API, admin, stream, and manifest requests
    const url = new URL(event.request.url);
    if (url.pathname.includes('/livewire') ||
        url.pathname.includes('/api/') ||
        url.pathname.includes('/admin') ||
        url.pathname.includes('/stream/') ||
        url.pathname.includes('manifest.json') ||
        url.searchParams.has('_wire')) {
        return;
    }

    // Network-first with optional cache fallback
    event.respondWith(
        fetch(event.request)
            .then(response => {
                if (response.status === 200 && response.type === 'basic') {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request, clone);
                    });
                }
                return response;
            })
            .catch(() => {
                return caches.match(event.request).then(cached => {
                    if (cached) return cached;
                    if (event.request.mode === 'navigate') {
                        return caches.match(OFFLINE_URL);
                    }
                    return new Response('', { status: 408 });
                });
            })
    );
});
