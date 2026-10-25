<?php

return [
    'ads' => [
        [
            'url' => 'https://eventy.io/?utm_source=Laravel.io&utm_campaign=eventy&utm_medium=advertisement',
            'image' => 'eventy',
            'alt' => 'Eventy',
        ],
    ],

    'moderation' => [
        'provider' => env('AI_MODERATION_PROVIDER', 'openai'),
        'model' => env('AI_MODERATION_MODEL') ?: null,
        'timeout' => 30,
    ],
];
