<?php
return [
    'backup' => [
        'dropbox' => [
            'token' => env('DROPBOX_TOKEN','not set:DROPBOX_TOKEN'),
            'path' => env('DROPBOX_PATH', 'not set:DROPBOX_PATH'),
        ],
    ],
];