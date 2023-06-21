<?php

return [
    'ads' => [
        ['url' => 'https://larajobs.com', 'image' => 'larajobs', 'alt' => 'LaraJobs', 'goal' => '9C3CAYKR'],
        ['url' => 'https://fullstackeurope.com/2023?utm_source=Laravel.io&utm_campaign=fseu23&utm_medium=advertisement', 'image' => 'fseu', 'alt' => 'Full Stack Europe', 'goal' => 'SRIK2PEE'],
        ['url' => 'https://loadforge.com', 'image' => 'loadforge', 'alt' => 'LoadForge', 'goal' => '5KTDAJ04'],
        [
            'random' => [
                [
                    'small' => ['url' => 'https://www.jetbrains.com/phpstorm/laravel/?utm_source=laravel.io&utm_medium=cpc&utm_campaign=phpstorm&utm_content=forum', 'image' => 'jetbrains-300x250', 'alt' => 'JetBrains', 'goal' => 'EMMLWQLC'],
                    'long' => ['url' => 'https://www.jetbrains.com/phpstorm/laravel/?utm_source=laravel.io&utm_medium=cpc&utm_campaign=phpstorm&utm_content=main', 'image' => 'jetbrains-1896x180', 'alt' => 'JetBrains', 'goal' => 'EMMLWQLC'],
                ],
                [
                    'small' => ['url' => 'https://www.jetbrains.com/phpstorm/laravel/?utm_source=laravel.io&utm_medium=cpc&utm_campaign=phpstorm&utm_content=forum_1', 'image' => 'jetbrains-300x250-1', 'alt' => 'JetBrains', 'goal' => 'EMMLWQLC'],
                    'long' => ['url' => 'https://www.jetbrains.com/phpstorm/laravel/?utm_source=laravel.io&utm_medium=cpc&utm_campaign=phpstorm&utm_content=main_1', 'image' => 'jetbrains-1896x180-1', 'alt' => 'JetBrains', 'goal' => 'EMMLWQLC'],
                ],
                [
                    'small' => ['url' => 'https://www.jetbrains.com/phpstorm/laravel/?utm_source=laravel.io&utm_medium=cpc&utm_campaign=phpstorm&utm_content=forum_2', 'image' => 'jetbrains-300x250-2', 'alt' => 'JetBrains', 'goal' => 'EMMLWQLC'],
                    'long' => ['url' => 'https://www.jetbrains.com/phpstorm/laravel/?utm_source=laravel.io&utm_medium=cpc&utm_campaign=phpstorm&utm_content=main_2', 'image' => 'jetbrains-1896x180-2', 'alt' => 'JetBrains', 'goal' => 'EMMLWQLC'],
                ],
            ],
        ],
    ],

    'horizon' => [
        'email' => env('LIO_HORIZON_EMAIL'),
        'webhook' => env('LIO_HORIZON_WEBHOOK'),
    ],

];
