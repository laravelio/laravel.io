<?php

return [
    'aws' => [
        'key' => getenv('DATABASE_BACKUP_KEY'),
        'secret' => getenv('DATABASE_BACKUP_SECRET'),
        'region' => Aws\Common\Enum\Region::IRELAND,
    ],
];
