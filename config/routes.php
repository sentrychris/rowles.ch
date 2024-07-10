<?php

/*----------------------------------------
 | Configure application routes           |
 ----------------------------------------*/

$app['router']->get('/', fn() => $app[Rowles\Controllers\HomeController::class]->index());