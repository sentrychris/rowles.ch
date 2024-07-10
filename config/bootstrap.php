<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

session_start();

/*----------------------------------------
 | Auto-load classes                      |
 ----------------------------------------*/
require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

/*----------------------------------------
 | Register service providers             |
 ----------------------------------------*/
$app = new App\Versyx\Service\Container();

$app->register(new App\Providers\LogServiceProvider());
$app->register(new App\Providers\RouteServiceProvider());
$app->register(new App\Providers\ViewServiceProvider());

/**
 * boot method to fetch services from the container
 *
 * @param mixed $dependency
 * @return mixed
 */
function app(mixed $dependency = null): mixed
{
    global $app;
    if (!$dependency) return $app;
    return $app->offsetExists($dependency) ? $app->offsetGet($dependency) : false;
}

/*----------------------------------------
 | Load resolver                          | 
 ----------------------------------------*/
require_once __DIR__.'/../config/resolver.php';

/*----------------------------------------
 | Set exception handler                  |
 ----------------------------------------*/
new App\Versyx\Exception\ExceptionHandler($app);