<?php

/*----------------------------------------
 | Configure application routes           |
 ----------------------------------------*/

use Pimple\Container;
use Rowles\Controllers\HomeController;

/** @var Container $app */
$router = $app['router'];

/**
 * Home page route.
 *
 * @var HomeController $home
 */
$router->get('/', fn() => $home->home());