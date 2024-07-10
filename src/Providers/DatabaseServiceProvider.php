<?php

namespace Rowles\Providers;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class LogServiceProvider
 */
class DatabaseServiceProvider implements ServiceProviderInterface
{
    /**
     * Register log service provider.
     *
     * @param Container $pimple
     * @return Container|string
     */
    public function register(Container $pimple)
    {
        $isDevMode = env('APP_DEBUG');
        $dbParams = [
            'driver'   => env('DB_DRIVER'),
            'user'     => env('DB_USER'),
            'password' => env('DB_PASSWORD'),
            'dbname'   => env('DB_NAME'),
        ];

        $paths = [__DIR__ . '../Entities'];
        $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
        $connection = DriverManager::getConnection($dbParams, $config);
        
        $pimple['em'] = new EntityManager($connection, $config);
    }
}