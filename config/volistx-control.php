<?php

return [
    'services' => [
        'GeoPoint' => [
            'base_uri' => 'volistx-framework.test',
            'class' => \Volistx\Control\Services\GeoPoint::class,
            'secure' => false,
            'access_key' => '',
        ],
        'BinPoint' => [
            'base_uri' => 'volistx-framework.test',
            'class' => \Volistx\Control\Services\BinPoint::class,
            'secure' => false,
            'access_key' => '',
        ],
        'UserPoint' => [
            'base_uri' => 'volistx-framework.test',
            'class' => \Volistx\Control\Services\UserPoint::class,
            'secure' => false,
            'access_key' => '',
        ],
    ]
];