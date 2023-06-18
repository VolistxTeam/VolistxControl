<?php

return [
    'services' => [
        'geopoint' => [
            'class' => \Volistx\Control\Services\GeoPoint::class,
            'secure' => false,
            'access_key' => env('GEOPOINT_KEY'),
        ],
    ]
];
