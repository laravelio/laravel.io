<?php

return [
    'ads' => [
        ['url' => 'https://eventy.io/?utm_source=Laravel.io&utm_campaign=eventy&utm_medium=advertisement', 'image' => 'eventy', 'alt' => 'Eventy', 'goal' => 'PSA8VL6S'],
        [
            'url' => 'https://bit.ly/49GlsSV',
            'image' => 'cloudways',
            'alt' => 'Cloudways',
            'goal' => '4KV6VZZ6',
        ],
    ],

    'horizon' => [
        'email' => env('LIO_HORIZON_EMAIL'),
        'webhook' => env('LIO_HORIZON_WEBHOOK'),
    ],

];
