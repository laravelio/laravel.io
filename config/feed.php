<?php

return [
    'feeds' => [
        'forum' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => ['App\Models\Thread@getFeedItems'],

            /*
             * The feed will be available on this url.
             */
            'url' => '/forum/rss',

            'title' => 'laravel.io Forum RSS Feed',
        ],
    ],
];
