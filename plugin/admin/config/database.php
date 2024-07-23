<?php

return [
    'default' => 'mysql',

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => getenv('DB_HOST') ?: "",
            'port' => getenv('DB_PORT') ?: 3306,
            'database' => getenv('DB_DATABASE') ?: "",
            'username' => getenv('DB_USERNAME') ?: "root",
            'password' => getenv('DB_PASSWORD') ?: "",
            'unix_socket' => '',
            'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
            'collation' => getenv('DB_COLLATION') ?: 'utf8mb4_general_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
    ],
];