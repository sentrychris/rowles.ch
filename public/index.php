<?php

use App\Versyx\View\ViewEngineInterface;
use FastRoute\Dispatcher;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

/*----------------------------------------
 | Bootstrap the application              |
 ----------------------------------------*/
require_once __DIR__.'/../config/bootstrap.php';

/*----------------------------------------
 | Dispatch the request-response cycle    |
 ----------------------------------------*/
 $request = ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$route = $app['router']->dispatch(
    $request->getMethod(),
    $request->getUri()->getPath()
);

switch ($route[0]) {
    case Dispatcher::NOT_FOUND:
        $response = $app[ViewEngineInterface::class]->render('error/404.twig');
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $response = $app[ViewEngineInterface::class]->render('error/500.twig');
        break;
    case Dispatcher::FOUND:
        $handler = $route[1];
        $vars = $route[2];
        [$class, $method] = $handler;
        
        $controller = $app[$class];
        $response = $controller->$method($request, $vars);
        break;
}

(new SapiEmitter())->emit(new HtmlResponse($response));
