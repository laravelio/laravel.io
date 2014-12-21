<?php

use OAuth\OAuth2\Service\GitHub;

return [
    'storage' => 'Session',
    'consumers' => [
        'GitHub' => [
            'client_id' => getenv('GITHUB_CLIENT_ID'),
            'client_secret' => getenv('GITHUB_CLIENT_SECRET'),
            'scope' => [GitHub::SCOPE_USER_EMAIL],
        ],
    ],
];
