<?php

/*------------------------------------------------------
 | Register controllers and inject services            |
 ------------------------------------------------------*/

use Rowles\Controllers\HomeController;


// TODO use reflection, loop through controller namespace, inspect dependencies
// and load dynamically.
$app[HomeController::class] = fn() => new HomeController($app['test']); // DI test