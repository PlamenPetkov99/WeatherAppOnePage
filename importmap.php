<?php

return [
    'app' => ['path' => './assets/app.js', 'entrypoint' => true],
    '@hotwired/stimulus' => ['version' => '3.2.2'],
    '@symfony/stimulus-bundle' => ['path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js'],
    '@hotwired/turbo' => ['version' => '8.0.23'],
    '@googlemaps/js-api-loader' => ['version' => '2.1.1'],
    '@symfony/ux-google-map' => ['path' => './vendor/symfony/ux-google-map/assets/dist/map_controller.js'],
    'leaflet' => ['version' => '1.9.4'],
    'leaflet/dist/leaflet.min.css' => ['version' => '1.9.4', 'type' => 'css'],
    '@symfony/ux-leaflet-map' => ['path' => './vendor/symfony/ux-leaflet-map/assets/dist/map_controller.js'],
    '@symfony/ux-live-component' => ['path' => './vendor/symfony/ux-live-component/assets/dist/live_controller.js'],
];
