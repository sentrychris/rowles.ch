<?php

/*----------------------------------------
 | Configure application routes           |
 ----------------------------------------*/

use Pimple\Container;
use Rowles\Controllers\BlogController;
use Rowles\Controllers\PageController;

/**
 * @var Container $app
 * @var PageController $page
 * @var BlogController $blog
 */

$app['router']->get('/', function () use ($page) {
    return $page->home();
});

$app['router']->get('/experience', function () use ($page) {
    return $page->experience(['title' => 'Experience']);
});

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