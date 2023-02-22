<?php

return [

    'ads' => [
        ['url' => 'https://larajobs.com', 'image' => 'larajobs', 'alt' => 'LaraJobs', 'goal' => '9C3CAYKR'],
        ['url' => 'https://fullstackeurope.com/2023?utm_source=Laravel.io&utm_campaign=fseu23&utm_medium=advertisement', 'image' => 'fseu', 'alt' => 'Full Stack Europe', 'goal' => 'SRIK2PEE'],
        ['url' => 'https://loadforge.com', 'image' => 'loadforge', 'alt' => 'LoadForge', 'goal' => '5KTDAJ04'],
    ],

    'horizon' => [
        'email' => env('LIO_HORIZON_EMAIL'),
        'webhook' => env('LIO_HORIZON_WEBHOOK'),
    ],

];
