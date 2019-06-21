<?php
return [
    'backup' => [
        'dropbox' => [
            'token' => env('DROPBOX_TOKEN','not set:DROPBOX_TOKEN'),
            'path' => env('DROPBOX_PATH', 'not set:DROPBOX_PATH'),
        ],
        'database' => [
            'admin' => [
                'username' => env('DB_ADMIN_USERNAME', 'not set:DB_ADMIN_USERNAME'),
                'password' => env('DB_ADMIN_PASSWORD', 'not set: DB_ADMIN_PASSWORD'),
            ],
        ],
    ],
];