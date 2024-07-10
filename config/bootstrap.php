<?php

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
$app = new App\Container();

$app->register(new App\Providers\LogServiceProvider());
$app->register(new App\Providers\RouteServiceProvider());
$app->register(new App\Providers\ViewServiceProvider());

/**
 * boot method to fetch services from the container
 *
 * @param $dependency
 * @return mixed
 */
function app($dependency = null)
{
    global $app;
    if (!$dependency) return $app;
    return $app->offsetExists($dependency) ? $app->offsetGet($dependency) : false;
}

/*----------------------------------------
 | Load controllers                       | 
 ----------------------------------------*/
require_once __DIR__.'/../config/controllers.php';

/*----------------------------------------
 | Load application routes                |
 ----------------------------------------*/
require_once __DIR__.'/../config/routes.php';

/*----------------------------------------
 | Set exception handler                  |
 ----------------------------------------*/
new App\ExceptionHandler($app);