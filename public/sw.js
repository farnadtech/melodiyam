const CACHE_NAME = 'melodiyam-v3';
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

// Fetch — network-only for HTML pages; cache-only for static assets (JS/CSS/images)
self.addEventListener('fetch', event => {
    // Skip non-GET requests
    if (event.request.method !== 'GET') return;

    const url = new URL(event.request.url);

    // Skip Livewire AJAX, API, admin, stream, and manifest requests — let them pass through
    if (url.pathname.includes('/livewire') ||
        url.pathname.includes('/api/') ||
        url.pathname.includes('/admin') ||
        url.pathname.includes('/stream/') ||
        url.pathname.includes('manifest.json') ||
        url.searchParams.has('_wire')) {
        return;
    }

    // Full page navigations (browser address bar, regular <a> clicks) — network only
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

    // Static assets (JS, CSS, images, fonts) — network-first with cache fallback
    const isStaticAsset = /\.(js|css|png|jpg|jpeg|gif|svg|webp|woff2?|ttf|eot|ico)(\?.*)?$/.test(url.pathname);

    if (isStaticAsset) {
        event.respondWith(
            caches.match(event.request).then(cachedResponse => {
                if (cachedResponse) return cachedResponse;
                return fetch(event.request).then(response => {
                    if (response.status === 200 && response.type === 'basic') {
                        const clone = response.clone();
                        caches.open(CACHE_NAME).then(cache => {
                            cache.put(event.request, clone);
                        });
                    }
                    return response;
                }).catch(() => new Response('', { status: 408 }));
            })
        );
        return;
    }

    // Everything else (wire:navigate HTML fetches, AJAX, etc.) — network only, no cache
    event.respondWith(
        fetch(event.request).catch(() => new Response('', { status: 503 }))
    );
});
