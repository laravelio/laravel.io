<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'github' => [
        'client_id' => env('GITHUB_ID'),
        'client_secret' => env('GITHUB_SECRET'),
        'redirect' => env('GITHUB_URL'),
    ],

    'google' => [
        'ad_sense' => [
            'client' => env('GOOGLE_AD_SENSE_AD_CLIENT'),
            'unit_footer' => env('GOOGLE_AD_SENSE_UNIT_FOOTER'),
            'unit_forum_sidebar' => env('GOOGLE_AD_SENSE_UNIT_FORUM_SIDEBAR'),
        ],
    ],

    'twitter' => [
        'consumer_key' => env('TWITTER_CONSUMER_KEY'),
        'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
        'access_token' => env('TWITTER_ACCESS_TOKEN'),
        'access_secret' => env('TWITTER_ACCESS_SECRET'),
    ],

    'telegram-bot-api' => [
        'token' => env('TELEGRAM_BOT_TOKEN'),
        'channel' => env('TELEGRAM_CHANNEL'),
    ],

    'fathom' => [
        'site_id' => env('FATHOM_SITE_ID'),
        'token' => env('FATHOM_TOKEN'),
    ],

    'unsplash' => [
        'access_key' => env('UNSPLASH_ACCESS_KEY'),
    ],

];
