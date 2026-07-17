<?php

namespace App\Manager;

use Symfony\UX\Map\Bridge\Leaflet\LeafletOptions;
use Symfony\UX\Map\Bridge\Leaflet\Option\TileLayer;
use Symfony\UX\Map\Map;

class MapManager
{
    private const string URL = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';

    public function buildMap(): Map
    {
        return new Map('default')->fitBoundsToMarkers(true)->options(
        new LeafletOptions()->tileLayer(
            new TileLayer(
                    url: self::URL,
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                )
            )
        );
    }
}
