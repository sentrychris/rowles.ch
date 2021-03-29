<?php

/*----------------------------------------
 | Register application controllers       |
 ----------------------------------------*/

use Rowles\Controllers\{BlogController, PageController};
use Rowles\Controllers\Auth\{AuthController, RegisterController, LoginController};

/** @var $app */
$controllers = [
    'auth' => new AuthController($app),
    'register' => new RegisterController($app),
    'login' => new LoginController($app),
    'page' => new PageController($app),
    'blog' => new BlogController($app)
];

return extract($controllers);
