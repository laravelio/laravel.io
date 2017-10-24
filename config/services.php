<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'github' => [
        'client_id' => env('GITHUB_ID'),
        'client_secret' => env('GITHUB_SECRET'),
        'redirect' => env('GITHUB_URL'),
    ],

    'akismet' => [
        'api_key' => env('AKISMET_API_KEY'),
    ],

    'intercom' => [
        'app_id' => env('INTERCOM_APP_ID'),
        'secret' => env('INTERCOM_SECRET'),
    ],

    'google' => [
        'ad_sense' => [
            'enabled' => env('GOOGLE_AD_SENSE_ENABLED', false),
            'client' => env('GOOGLE_AD_SENSE_AD_CLIENT'),
            'unit_footer' => env('GOOGLE_AD_SENSE_UNIT_FOOTER'),
            'unit_forum_sidebar' => env('GOOGLE_AD_SENSE_UNIT_FORUM_SIDEBAR'),
        ],
    ],

    'carbon' => [
        'code' => env('CARBON_CODE'),
    ],

];
