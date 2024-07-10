<?php

/*------------------------------------------------------
 | Register controllers and inject services            |
 ------------------------------------------------------*/

use Rowles\Controllers\HomeController;

 $app[HomeController::class] = function ($container) {
    return new HomeController($container['log'], $container['view']);
};