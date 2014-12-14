<?php

return [
    'storage' => 'Session',

    'consumers' => [
        'GitHub' => [
            'client_id'     => getenv('GITHUB_CLIENT_ID'),
            'client_secret' => getenv('GITHUB_CLIENT_SECRET'),
            'scope'         => ['user'],
        ],
    ],
];