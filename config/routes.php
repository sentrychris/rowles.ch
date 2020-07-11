<?php

/*----------------------------------------
 | Configure application routes           |
 ----------------------------------------*/

/** @var \Rowles\Controllers\PageController $page */
$app['router']->get('/', function () use ($page) {
    return $page->home();
});

/** @var \Rowles\Controllers\PageController $page */
$app['router']->get('/experience', function () use ($page) {
    return $page->experience(['title' => 'Experience']);
});

/** @var \Rowles\Controllers\BlogController $blog */
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