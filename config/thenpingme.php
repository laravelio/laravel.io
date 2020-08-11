<?php

return [

    'project_id' => env('THENPINGME_PROJECT_ID'),

    'signing_key' => env('THENPINGME_SIGNING_KEY'),

    'queue_ping' => env('THENPINGME_QUEUE_PING', true),

    // Capture git sha with ping
    // 'release' => trim(exec('git --git-dir ' . base_path('.git') . ' log --pretty="%h" -n1 HEAD')),

    'api_url' => env('THENPINGME_API_URL', 'https://thenping.me/api'),

];
