<?php

/*----------------------------------------
 | Register application controllers       |
 ----------------------------------------*/

use Rowles\Controllers\Auth\{RegisterController, LoginController};
use Rowles\Controllers\{BlogController, PageController};

/** @var $app */
$controllers = [
    'register' => new RegisterController($app),
    'login' => new LoginController($app),
    'page' => new PageController($app),
    'blog' => new BlogController($app)
];

return extract($controllers);
