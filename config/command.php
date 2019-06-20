<?php
return [
    'container' => [
        'db' => [
            'name' => env('DB_CONTAINER', 'mysql'),
        ],
    ],
    'backup' => [
        'dropbox' => [
            'token' => env('PRODUCT_BACKUP_DROPBOX_TOKEN','not set:PRODUCT_BACKUP_DROPBOX_TOKEN'),
            'path' => env('PRODUCT_BACKUP_DROPBOX_PATH', 'not set:PRODUCT_BACKUP_DROPBOX_PATH'),
        ],
    ],
];