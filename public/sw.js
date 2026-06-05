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

// Fetch — network only for navigation to avoid PWA issues, cache assets
self.addEventListener('fetch', event => {
    // Skip non-GET requests
    if (event.request.method !== 'GET') return;

    const url = new URL(event.request.url);

    // Skip Livewire, API, admin, stream, and manifest requests
    if (url.pathname.includes('/livewire') ||
        url.pathname.includes('/api/') ||
        url.pathname.includes('/admin') ||
        url.pathname.includes('/stream/') ||
        url.pathname.includes('manifest.json') ||
        url.searchParams.has('_wire')) {
        return;
    }

    // For navigation requests (HTML pages), always go to network
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request).catch(() => {
                return caches.match(OFFLINE_URL).then(cached => {
                    return cached || new Response('Offline', {
                        status: 503,
                        statusText: 'Service Unavailable',
                        headers: new Headers({ 'Content-Type': 'text/html' })
                    });
                });
            })
        );
        return;
    }

    // For other assets (JS, CSS, Images), use cache-first or network-first
    event.respondWith(
        caches.match(event.request).then(cachedResponse => {
            if (cachedResponse) return cachedResponse;

            return fetch(event.request).then(response => {
                // Cache successful responses for assets
                if (response.status === 200 && response.type === 'basic') {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request, clone);
                    });
                }
                return response;
            }).catch(() => {
                return new Response('', { status: 408 });
            });
        })
    );
});
