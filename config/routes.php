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
$router->get('/', function () use ($home) {
    return $home->home();
});

/**
 * Auth routes.
 *
 * @var AuthController $auth
 * @var RegisterController $register
 * @var LoginController $login
 */
if (env('APP_ENV') !== 'production') {
    $router->get('/register', function () use ($register) {
        return $register->view();
    });
    $router->post('/register', function ($request, $response) use ($register) {
        return $register->submit($request, $response);
    });
}

$router->get('/login', function () use ($login) {
    return $login->view();
});

$router->post('/login', function ($request, $response) use ($login) {
    return $login->submit($request, $response);
});

$router->get('/logout', function ($request, $response) use ($auth) {
    return $auth->logout($request, $response);
});


/**
 * Blog routes.
 *
 * @var BlogController $blog
 */
$router->with('/blog', function () use ($router, $blog) {
    $router->get('', function () use ($blog) {
        return $blog->home(['title' => 'Blog']);
    });

    $router->get('/create', function () use ($blog) {
        return $blog->create(['title' => 'New Post']);
    });

    $router->get('/[s:created]/[s:title]', function ($request) use ($blog) {
        return $blog->view($request->created, $request->title);
    });

    $router->get('/[i:id]/edit', function ($request) use ($blog) {
        return $blog->edit($request->id);
    });

    $router->post('/[i:id]?/submit', function ($request, $response) use ($blog) {
        return $blog->submit($request, $response);
    });

    $router->get('/[i:id]/delete', function ($request, $response) use ($blog) {
        return $blog->delete($request, $response);
    });
});
