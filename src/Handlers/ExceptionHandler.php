<?php

namespace Rowles\Handlers;

use Pimple\Container;
use Psr\Log\LoggerInterface;

/**
 * Class ExceptionHandler
 */
class ExceptionHandler
{
    /** @var mixed $log */
    protected $log;

    /** @var mixed $view */
    protected $view;

    /** @var mixed $router */
    protected $router;

    const HTTP_NOTFOUND = 404;

    /**
     * ExceptionHandler constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->log = $container[LoggerInterface::class];
        $this->view = $container['view'];
        $router = $container['router'];

        $router->respond(function () use ($router) {
            $router->onHttpError(function ($code, $router) {
                if (!env('APP_DEBUG')) {
                    switch ($code) {
                        case self::HTTP_NOTFOUND:
                            $router->response()->body($this->view->render('error/404.twig'));
                            break;
                        default:
                            $router->response()->body($this->view->render('error/500.twig'));
                    }
                } else {
                    $router->response()->body($router->response()->status());
                }
            });
        });

        set_exception_handler([$this, 'handle']);
    }

    /**
     * Handle exception.
     *
     * @param $exception
     */
    public function handle($exception)
    {
        $this->log->error($exception->getMessage());
        echo $this->view->render('error/500.twig', [
            'debug' => env('APP_DEBUG'),
            'error' => $exception->getMessage(),
            'trace' => ltrim($exception->getPrevious()->getTraceAsString())
        ]);
    }
}