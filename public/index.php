<?php

use FastRoute\Dispatcher;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use App\Versyx\View\ViewEngineInterface;
use Laminas\Diactoros\Response\HtmlResponse;

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
        $response = new HtmlResponse(
            $app[ViewEngineInterface::class]->render('error/404.twig')
        );
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $response = new HtmlResponse(
            $app[ViewEngineInterface::class]->render('error/500.twig')
        );
        break;
    case Dispatcher::FOUND:
        $handler = $route[1];
        $routeParams = $route[2];
        [$class, $method] = $handler;
        
        $controller = $app[$class];
        $response = $controller->$method($request, $routeParams);

        if (! $response instanceof ResponseInterface) {
            throw new \RuntimeException(
                $class. '->'.$method.' must return a valid PSR-7 response'
            );
        }

        break;
}

(new SapiEmitter())->emit($response);
