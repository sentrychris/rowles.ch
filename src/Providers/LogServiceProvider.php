<?php

namespace Rowles\Providers;

use Monolog\Logger;
use Pimple\Container;
use Monolog\Handler\StreamHandler;
use Pimple\ServiceProviderInterface;
use Psr\Log\LoggerInterface;

/**
 * Class LogServiceProvider
 */
class LogServiceProvider implements ServiceProviderInterface
{
    /**
     * Register log service provider.
     *
     * @param Container $pimple
     * @return Container|string
     */
    public function register(Container $pimple)
    {
        $pimple[LoggerInterface::class] = new Logger('app');

        try {
            $pimple[LoggerInterface::class]->pushHandler(new StreamHandler($this->logPath(), Logger::DEBUG));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $pimple;
    }

    /**
     * Resolve log path.
     *
     * @return string
     */
    private function logPath(): string
    {
        return __DIR__ . '/../../logs/app.log';
    }
}