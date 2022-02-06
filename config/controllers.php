<?php

/*----------------------------------------
 | Register application controllers       |
 ----------------------------------------*/

use Rowles\Controllers\{BlogController, HomeController};
use Rowles\Controllers\Auth\{AuthController, RegisterController, LoginController};

/** @var $app */
$controllers = [
    'auth' => new AuthController($app),
    'register' => new RegisterController($app),
    'login' => new LoginController($app),
    'home' => new HomeController($app),
    'blog' => new BlogController($app)
];

return extract($controllers);
