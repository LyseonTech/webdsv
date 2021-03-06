<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;
use Slim\Views\Twig;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => false,
            'uploadDir' => __DIR__.'/../var/uploads/',
            'logger' => [
                'name' => 'slim-app',
                'path' => __DIR__.'/../var/logs/app.log',
                'level' => Logger::WARNING,
            ],
        ],
        'view' => Twig::create(__DIR__.'/../templates/', [
            'cache' => __DIR__.'/../var/cache/',
        ]),
    ]);
};
