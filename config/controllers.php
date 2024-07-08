<?php

/*----------------------------------------
 | Register application controllers       |
 ----------------------------------------*/

use Rowles\Controllers\HomeController;
// use Rowles\Controllers\BlogController;
// use Rowles\Controllers\Auth\{AuthController, RegisterController, LoginController};

/** @var array */
$controllers = [
    // 'auth' => new AuthController($app),
    // 'register' => new RegisterController($app),
    // 'login' => new LoginController($app),
    'home' => new HomeController($app),
    // 'blog' => new BlogController($app)
];

return extract($controllers);
