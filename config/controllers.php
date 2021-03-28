<?php

/*----------------------------------------
 | Register application controllers       |
 ----------------------------------------*/

use Rowles\Controllers\AuthController;
use Rowles\Controllers\BlogController;
use Rowles\Controllers\PageController;

/** @var $app */
$controllers = [
    'auth' => new AuthController($app),
    'page' => new PageController($app),
    'blog' => new BlogController($app)
];

return extract($controllers);
