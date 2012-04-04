<?php

namespace Silicone\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Silicone\Component\Database\HandlerFactory;

/**
 * Silicone Database component Provider.
 *
 * @author Ayumu Sato <mail@ayumusato.com>
 */
class DatabaseServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['db'] = $app->share(function () use ($app) {
            return new HandlerFactory($app['db.config']);
        });
    }
}
