<?php

namespace App\Providers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;
use App\Versyx\Service\Container;
use App\Versyx\Service\ServiceProviderInterface;

/**
 * Class LogServiceProvider
 */
class LogServiceProvider implements ServiceProviderInterface
{
    /**
     * Register log service provider.
     *
     * @param Container $container
     * @return Container|string
     */
    public function register(Container $container): Container
    {
        $container[LoggerInterface::class] = new Logger('app');

        try {
            $container[LoggerInterface::class]->pushHandler(new StreamHandler($this->logPath(), Logger::DEBUG));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $container;
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