<?php

use Swoft\Http\Server\HttpServer;
use Swoft\Redis\RedisDb;

return [
    'logger'     => [
        'flushRequest' => false,
        'enable'       => false,
        'json'         => false,
    ],
    'processPool' => [
        'class' => \Swoft\Process\ProcessPool::class,
        'workerNum' => 3
    ],
    'redis'             => [
        'class'    => RedisDb::class,
        'host'     => env('REDIS_HOST','127.0.0.1'),
        'port'     => 6379,
        'database' => 0,
        'option'   => [
            'prefix' => 'queue:'
        ]
    ],
];
