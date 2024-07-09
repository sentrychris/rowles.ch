<?php

/*----------------------------------------
 | Register application controllers       |
 ----------------------------------------*/

use Rowles\Controllers\HomeController;

/** @var array */
$controllers = [
    'home' => new HomeController($app),
];

return extract($controllers);
