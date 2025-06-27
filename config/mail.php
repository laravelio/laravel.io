<?php

return [

    'mailers' => [
        'mailcoach' => [
            'transport' => 'mailcoach',
            'domain' => env('MAILCOACH_DOMAIN'),
            'token' => env('MAILCOACH_TOKEN'),
        ],
    ],

];
