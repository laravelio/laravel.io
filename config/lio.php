<?php

return [

    'ads' => [
        ['url' => 'https://devsquad.com', 'image' => 'devsquad', 'alt' => 'Devsquad', 'goal' => 'MMCR7T3S'],
        ['url' => 'https://masteringnova.com?ref=laravelio ', 'image' => 'mastering-nova', 'alt' => 'Mastering Nova', 'goal' => 'B5PGZD9N'],
    ],

    'horizon' => [
        'email' => env('LIO_HORIZON_EMAIL'),
        'webhook' => env('LIO_HORIZON_WEBHOOK'),
    ],

];
