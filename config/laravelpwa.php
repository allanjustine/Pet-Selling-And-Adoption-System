<?php

return [
    'name' => 'Fur-fect',
    'manifest' => [
        'name' => env('APP_NAME', 'Fur-fect'),
        'short_name' => 'Fur-fect',
        'start_url' => '/',
        'id' => '/',
        'background_color' => '#C66930',
        'theme_color' => '#C66930',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'description' => 'Fur-fect: A mobile and web-based online platform for Pet lovers',
        'screenshots' => [
            [
                'src' => '/img/pwa/screenshots/1.jpg',
                'sizes' => '1080x1920',
                'type' => 'image/jpg',
                'platform' => 'narrow',
                'label' => 'Login Page',
            ],
            [
                'src' => '/img/pwa/screenshots/2.jpg',
                'sizes' => '1080x1920',
                'type' => 'image/jpg',
                'platform' => 'narrow',
                'label' => 'Market Place',
            ],
            [
                'src' => '/img/pwa/screenshots/3.jpg',
                'sizes' => '1080x1920',
                'type' => 'image/jpg',
                'platform' => 'narrow',
                'label' => 'Community',
            ],
            [
                'src' => '/img/pwa/screenshots/4.jpg',
                'sizes' => '1080x1920',
                'type' => 'image/jpg',
                'platform' => 'narrow',
                'label' => 'Extras',
            ],
        ],
        'icons' => [
            '48x48' => [
                'path' => '/img/pwa/icons/icon-48x48.png',
                'purpose' => 'any'
            ],
            '72x72' => [
                'path' => '/img/pwa/icons/icon-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/img/pwa/icons/icon-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/img/pwa/icons/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/img/pwa/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/img/pwa/icons/icon-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/img/pwa/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '284x284' => [
                'path' => '/img/pwa/icons/icon-284x284.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/img/pwa/icons/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            // '640x1136' => '/images/icons/splash-750x1334.png',
            // '750x1334' => '/images/icons/splash-750x1334.png',
            // '828x1792' => '/images/icons/splash-828x1792.png',
            // '1125x2436' => '/images/icons/splash-1125x2436.png',
            // '1242x2208' => '/images/icons/splash-1242x2208.png',
            // '1242x2688' => '/images/icons/splash-1242x2688.png',
            // '1536x2048' => '/images/icons/splash-1536x2048.png',
            // '1668x2224' => '/images/icons/splash-1668x2224.png',
            // '1668x2388' => '/images/icons/splash-1668x2388.png',
            // '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Login',
                'description' => 'to login page',
                'url' => '/login',
                'icons' => [
                    "src" => "/img/pwa/icons/icon-96x96.png",
                    "purpose" => "any"
                ]
            ],
        ],
        'custom' => []
    ]
];