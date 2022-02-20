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
$app = new Pimple\Container();

$app->register(new Rowles\Providers\LogServiceProvider());
$app->register(new Rowles\Providers\DatabaseServiceProvider());
$app->register(new Rowles\Providers\RouteServiceProvider());
$app->register(new Rowles\Providers\ViewServiceProvider());

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

new Rowles\Handlers\ExceptionHandler($app);
