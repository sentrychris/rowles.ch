<?php

/*----------------------------------------
 | Configure application routes           |
 ----------------------------------------*/

use Pimple\Container;
use Rowles\Controllers\Auth\RegisterController;
use Rowles\Controllers\{Auth\AuthController, Auth\LoginController, BlogController, HomeController};

/** @var Container $app */

/**
 * Static page routes.
 * @var HomeController $page
 */
$app['router']->get('/', function () use ($page) {
    return $page->home();
});


/**
 * Auth routes.
 * @var AuthController $auth
 * @var RegisterController $register
 * @var LoginController $login
 */
$app['router']->get('/register', function () use ($register) {
    return $register->view();
});
$app['router']->post('/register', function ($request, $response) use ($register) {
    return $register->submit($request, $response);
});
$app['router']->get('/login', function () use ($login) {
    return $login->view();
});
$app['router']->post('/login', function ($request, $response) use ($login) {
    return $login->submit($request, $response);
});
$app['router']->get('/logout', function ($request, $response) use ($auth) {
    return $auth->logout($request, $response);
});


/**
 * Blog routes.
 * @var BlogController $blog
 */
$app['router']->with('/blog', function () use ($app, $blog) {
    $app['router']->get('', function () use ($blog) {
        return $blog->home(['title' => 'Blog']);
    });
    $app['router']->get('/create', function () use ($blog) {
        return $blog->create(['title' => 'New Post']);
    });
    $app['router']->get('/[s:created]/[s:title]', function ($request) use ($blog) {
        return $blog->view($request->created, $request->title);
    });
    $app['router']->get('/[i:id]/edit', function ($request) use ($blog) {
        return $blog->edit($request->id);
    });
    $app['router']->post('/[i:id]?/submit', function ($request, $response) use ($blog) {
        return $blog->submit($request, $response);
    });
    $app['router']->get('/[i:id]/delete', function ($request, $response) use ($blog) {
        return $blog->delete($request, $response);
    });
});