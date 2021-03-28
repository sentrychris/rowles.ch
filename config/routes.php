<?php

/*----------------------------------------
 | Configure application routes           |
 ----------------------------------------*/

use Pimple\Container;
use Rowles\Controllers\AuthController;
use Rowles\Controllers\BlogController;
use Rowles\Controllers\PageController;

/**
 * @var Container $app
 * @var AuthController $auth
 * @var PageController $page
 * @var BlogController $blog
 */


/**
 * Static page routes.
 */
$app['router']->get('/experience', function () use ($page) {
    return $page->experience(['title' => 'Experience']);
});
$app['router']->get('/', function () use ($page) {
    return $page->home();
});



/**
 * Auth routes.
 */
$app['router']->with('/auth', function () use ($app, $auth) {
    $app['router']->post('/register', function ($request, $response) use ($auth) {
        return $auth->register($request, $response);
    });

    $app['router']->post('/login', function ($request, $response) use ($auth) {
        return $auth->login($request, $response);
    });
});


/**
 * Blog routes.
 */
$app['router']->with('/blog', function () use ($app, $blog) {
    $app['router']->get('', function () use ($blog) {
        return $blog->home(['title' => 'Blog']);
    });
    $app['router']->get('/create', function () use ($blog) {
        return $blog->create(['title' => 'New Post']);
    });
    $app['router']->get('/[i:id]/view', function ($request) use ($blog) {
        return $blog->view($request->id);
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