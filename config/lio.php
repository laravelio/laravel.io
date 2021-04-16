<?php

return [

    'ads' => [
        ['url' => 'https://devsquad.com', 'image' => 'devsquad', 'alt' => 'Devsquad', 'goal' => 'MMCR7T3S'],
        ['url' => 'https://larajobs.com', 'image' => 'larajobs', 'alt' => 'LaraJobs', 'goal' => '9C3CAYKR'],
    ],

    'horizon' => [
        'email' => env('LIO_HORIZON_EMAIL'),
        'webhook' => env('LIO_HORIZON_WEBHOOK'),
    ],

    'pagination' => [
        'onEachSide' => env('PAGINATION_ON_EACH_SIDE_COUNT', 5),
        'count' => env('PAGINATION_COUNT', 20),
    ],

];
