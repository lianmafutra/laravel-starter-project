<?php

return [
    'server' => [
        'host' => env('DEPLOY_HOST'),
        'port' => env('DEPLOY_PORT', 22),
        'path' => env('DEPLOY_PATH'),
        'username' => env('DEPLOY_USER', 'root'),
        'password' => env('DEPLOY_PASS'),
    ],
    'git-ftp' => [
        'url' => env('FTP_URL'),
        'user' => env('FTP_USER'),
        'password' => env('FTP_PASS'),
    ],
    'command-first-deploy' => [
        'php artisan key:generate',
        'php artisan migrate --force',
        'php artisan auth:clear-resets',
        'php artisan storage:link',
        'php artisan down',
        'php artisan optimize',
        'php artisan view:clear',
        'php artisan view:cache',
        'php artisan up',
    ],
    'command-deploy' => [
        'php artisan down',
        'php artisan optimize',
        'php artisan view:clear',
        'php artisan view:cache',
        'php artisan up',
    ],
    'command-optimize' => [
        'php artisan down',
        'php artisan optimize',
        'php artisan view:clear',
        'php artisan view:cache',
        'php artisan up',
    ],
];
