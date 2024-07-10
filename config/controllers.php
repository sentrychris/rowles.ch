<?php

/*------------------------------------------------------
 | Register controllers and inject services            |
 ------------------------------------------------------*/

use Rowles\Controllers\HomeController;

 $app[HomeController::class] = fn() => new HomeController($app['test']); // DI test