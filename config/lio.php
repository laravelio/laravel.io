<?php

return [
    'ads' => [
        // [
        //     'url' => 'https://eventy.io/?utm_source=Laravel.io&utm_campaign=eventy&utm_medium=advertisement',
        //     'image' => 'eventy',
        //     'alt' => 'Eventy',
        // ],
        [
            'url' => 'https://nativephp.com/mobile?ref=laravel.io',
            'image' => 'nativephp',
            'alt' => 'Native PHP',
        ],
    ],

    'horizon' => [
        'email' => env('LIO_HORIZON_EMAIL'),
        'webhook' => env('LIO_HORIZON_WEBHOOK'),
    ],

];
