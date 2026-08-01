const CACHE_VERSION = 'eye-clinic-v1';
const OFFLINE_URL = '/offline.html';
const PRECACHE = [
    OFFLINE_URL,
    '/manifest.webmanifest',
    '/icons/icon-192.png',
    '/icons/icon-512.png',
    '/icons/apple-touch-icon.png',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_VERSION)
            .then((cache) => cache.addAll(PRECACHE))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(
                keys
                    .filter((key) => key !== CACHE_VERSION)
                    .map((key) => caches.delete(key))
            )
        ).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    const { request } = event;

    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    if (url.origin !== self.location.origin) {
        return;
    }

    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(async () => {
                const cache = await caches.open(CACHE_VERSION);
                return (await cache.match(OFFLINE_URL)) || Response.error();
            })
        );
        return;
    }

    if (
        url.pathname.startsWith('/icons/') ||
        url.pathname.startsWith('/build/') ||
        url.pathname === '/manifest.webmanifest' ||
        url.pathname === OFFLINE_URL
    ) {
        event.respondWith(
            caches.open(CACHE_VERSION).then(async (cache) => {
                const cached = await cache.match(request);
                if (cached) {
                    return cached;
                }

                try {
                    const response = await fetch(request);
                    if (response.ok) {
                        cache.put(request, response.clone());
                    }
                    return response;
                } catch (error) {
                    return cached || Response.error();
                }
            })
        );
    }
});
