<?php

namespace Rowles\Core\Providers;

use Monolog\Logger;
use Pimple\Container;
use Monolog\Handler\StreamHandler;
use Pimple\ServiceProviderInterface;

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
    public function register(Container $container)
    {
        $container['log'] = new Logger('app');

        try {
            $container['log']->pushHandler(new StreamHandler($this->logPath(), Logger::DEBUG));
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
    private function logPath()
    {
        return __DIR__ . '/../../../logs/app.log';
    }
}