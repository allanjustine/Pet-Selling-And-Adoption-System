var staticCacheName = "pwa-vs" + new Date().getTime();
var filesToCache = [
    "/offline",
    "/img/errors/offline.svg",
    "/assets/css/bootstrap/bootstrap.css",
    "/assets/js/bootstrap/bootstrap.min.js",
    "/img/pwa/icons/icon-72x72.png",
    "/img/pwa/icons/icon-96x96.png",
    "/img/pwa/icons/icon-128x128.png",
    "/img/pwa/icons/icon-144x144.png",
    "/img/pwa/icons/icon-152x152.png",
    "/img/pwa/icons/icon-192x192.png",
    "/img/pwa/icons/icon-384x384.png",
    "/img/pwa/icons/icon-512x512.png",
    "https://fonts.googleapis.com/css?family=Nunito",
    "https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700",
];

// Cache on install.
self.addEventListener("install", (event) => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            return cache.addAll(filesToCache);
        })
    );
});

// Clear cache on activate
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName.startsWith("pwa-"))
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match("offline");
            })
    );
});
