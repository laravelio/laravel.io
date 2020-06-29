<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Icons Sets
    |--------------------------------------------------------------------------
    |
    | With this config option you can define a couple of
    | default icon sets. Provide a key name for your icon
    | set and a combination from the options below.
    |
    */

    'sets' => [

        'default' => [

            /*
            |-----------------------------------------------------------------
            | Icons Path
            |-----------------------------------------------------------------
            |
            | Provide the relative path from your app root to your
            | SVG icons directory. Icons are loaded recursively
            | so there's no need to list every sub-directory.
            |
            */

            'path' => 'resources/svg',

            /*
            |--------------------------------------------------------------------------
            | Default Prefix
            |--------------------------------------------------------------------------
            |
            | This config option allows you to define a default prefix for
            | your icons. The dash separator will be applied automatically
             to every icon name. It's required and needs to be unique.
            |
            */

            'prefix' => 'icon',

        ],

    ],

];
