<?php

/*----------------------------------------
 | Configure application routes           |
 ----------------------------------------*/

$app['router']->get('/', fn() => $app[App\Controllers\HomeController::class]->index());