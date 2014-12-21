<?php

return [
    'development' => [
        'type' => 'mysql',
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'root',
        'pass' => 'password',
        'database' => 'test',
    ],
    'production' => [
        'type' => 'postgresql',
        'host' => 'localhost',
        'port' => '5432',
        'user' => 'postgres',
        'pass' => 'password',
        'database' => 'test',
    ],
];
