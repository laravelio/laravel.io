<?php

return [

    'ads' => [
        ['url' => 'https://devsquad.com', 'image' => 'devsquad', 'alt' => 'Devsquad'],
        ['url' => 'https://masteringnova.com?ref=laravelio ', 'image' => 'mastering-nova', 'alt' => 'Mastering Nova'],
    ],

    'horizon' => [
        'email' => env('LIO_HORIZON_EMAIL'),
        'webhook' => env('LIO_HORIZON_WEBHOOK'),
    ],

];
