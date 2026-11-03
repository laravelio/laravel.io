<?php

return [
    'ads' => [
        [
            'url' => 'https://eventy.io/?utm_source=Laravel.io&utm_campaign=eventy&utm_medium=advertisement',
            'image' => 'eventy',
            'alt' => 'Eventy',
        ],
        [
            'url' => 'https://moneytrees.app/?utm_source=Laravel.io&utm_campaign=moneytrees&utm_medium=advertisement',
            'image' => 'moneytrees',
            'alt' => 'Moneytrees',
        ],
    ],

    'moderation' => [
        'provider' => env('AI_MODERATION_PROVIDER', 'openai'),
        'model' => env('AI_MODERATION_MODEL') ?: null,
        'timeout' => 30,
    ],
];
