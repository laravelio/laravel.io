<?php

return [

    'ads' => [
        ['url' => 'https://devsquad.com', 'image' => 'devsquad', 'alt' => 'Devsquad', 'goal' => 'MMCR7T3S'],
        ['url' => 'https://larajobs.com', 'image' => 'larajobs', 'alt' => 'LaraJobs', 'goal' => '9C3CAYKR'],
        ['url' => 'https://fullstackeurope.com/2021?utm_source=Laravel.io&utm_campaign=fseu21&utm_medium=advertisement', 'image' => 'fseu', 'alt' => 'Full Stack Europe', 'goal' => 'SRIK2PEE'],
    ],

    'horizon' => [
        'email' => env('LIO_HORIZON_EMAIL'),
        'webhook' => env('LIO_HORIZON_WEBHOOK'),
    ],

];
