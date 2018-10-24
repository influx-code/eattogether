<?php

use Providers\RouterProvider;

return [
    'autoload' => [
        'dirs' => [
            APP_PATH . '/controller/',
            APP_PATH . '/model/',
        ],
        'namespaces' => [
            'Controller' => APP_PATH .'/controller/',
            'Library' => LIBRARY_PATH,
            'Model' => APP_PATH . '/model/',
            'Common' => APP_PATH . '/common/',
            'Providers' => APP_PATH . '/providers/',
        ],
    ],
    'service' => [
        'redis' => [
            'lib' => '\Library\RedisAdapter',
            'config' => 'redis.php',
            'shared' => true,
        ],
        'db' => [
            'lib' => '\Library\MysqlAdapter',
            'config' => 'mysql.php',
            'shared' => true,
        ],
    ],
    'providers' => [
        RouterProvider::class,
    ],
];
