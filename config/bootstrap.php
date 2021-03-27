<?php

/*----------------------------------------
 | Auto-load classes                      |
 ----------------------------------------*/
require_once __DIR__.'/../vendor/autoload.php';

Dotenv\Dotenv::create(__DIR__ . '/../')->load();

/*----------------------------------------
 | Register service providers             |
 ----------------------------------------*/
$app = new Pimple\Container();

$app->register(new Rowles\Core\Providers\LogServiceProvider());
$app->register(new Rowles\Core\Providers\DatabaseServiceProvider());
$app->register(new Rowles\Core\Providers\RouteServiceProvider());
$app->register(new Rowles\Core\Providers\ViewServiceProvider());

/**
 * boot method to fetch services from the container
 *
 * @param $dependency
 * @return mixed
 */
function app($dependency = null)
{
    global $app;
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

new \Rowles\Core\Handlers\ExceptionHandler($app);
