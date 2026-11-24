<?php

return [
    'disks' => [
        'backups' => [
            'driver' => 's3',
            'key' => env('BACKUP_AWS_ACCESS_KEY_ID'),
            'secret' => env('BACKUP_AWS_SECRET_ACCESS_KEY'),
            'region' => env('BACKUP_AWS_DEFAULT_REGION'),
            'bucket' => env('BACKUP_AWS_BUCKET'),
            'visibility' => 'private',
            'throw' => true,
        ],
    ],
];
