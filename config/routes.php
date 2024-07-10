<?php

/*----------------------------------------
 | Configure application routes           |
 ----------------------------------------*/
/**
 * Home page route.
 *
 * @var HomeController $home
 */
$app['router']->get('/', function() use ($app) {
    return $app[Rowles\Controllers\HomeController::class]->index();
});