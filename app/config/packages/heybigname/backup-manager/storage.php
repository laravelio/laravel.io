<?php

return [
    'local' => [
        'type' => 'Local',
        'root' => storage_path('dumps'),
    ],
    's3' => [
        'type' => 'AwsS3',
        'key' => getenv('AWS_KEY'),
        'secret' => getenv('AWS_SECRET'),
        'region' => Aws\Common\Enum\Region::FRANKFURT,
        'bucket' => getenv('DATABASE_BACKUP_S3_BUCKET'),
        'root' => '',
    ],
];
