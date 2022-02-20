<?php

/*----------------------------------------
 | Configure application routes           |
 ----------------------------------------*/

use Pimple\Container;
use Rowles\Controllers\Auth\RegisterController;
use Rowles\Controllers\{Auth\AuthController, Auth\LoginController, BlogController, HomeController};

/** @var Container $app */
$router = $app['router'];

/**
 * Home page route.
 *
 * @var HomeController $home
 */
$router->get('/', fn() => $home->home());

/**
 * Auth routes.
 *
 * @var AuthController $auth
 * @var RegisterController $register
 * @var LoginController $login
 */
$router->get('/register', fn() => $register->view());
$router->post('/register', fn($request, $response) => $register->submit($request, $response));
$router->get('/login', fn() => $login->view());
$router->post('/login', fn($request, $response) => $login->submit($request, $response));
$router->post('/logout', fn($request, $response) => $auth->logout($request, $response));


/**
 * Blog routes.
 *
 * @var BlogController $blog
 */
$router->with('/blog', function () use ($router, $blog) {
    $router->get('', fn() => $blog->home(['title' => 'Blog']));
    $router->get('/create', fn() => $blog->create(['title' => 'New Post']));
    $router->get('/[i:id]', fn($request) => $blog->view($request->id));
    $router->get('/[i:id]/edit', fn($request) =>$blog->edit($request->id));
    $router->post('/[i:id]?/submit', fn($request, $response) => $blog->submit($request, $response));
    $router->delete('/[i:id]/delete', fn($request, $response) => $blog->delete($request, $response));
});
