<?php

namespace App\Versyx\Exception;

use Psr\Log\LoggerInterface;
use App\Versyx\Service\Container;
use App\Versyx\View\ViewEngineInterface;

/**
 * Class ExceptionHandler
 */
class ExceptionHandler
{
    /** @var mixed $log */
    protected $log;

    /** @var mixed $view */
    protected $view;

    /**
     * ExceptionHandler constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->log = $container[LoggerInterface::class];
        $this->view = $container[ViewEngineInterface::class];

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