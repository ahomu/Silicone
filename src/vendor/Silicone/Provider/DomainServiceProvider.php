<?php

namespace Silicone\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Silicone\Component\Domain\ActionControllerCollection;

/**
 * Silicone functional Domain component Provider.
 *
 * @author Ayumu Sato <mail@ayumusato.com>
 */
class DomainServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['domain'] = $app->share(function () use ($app) {
            return new ActionControllerCollection($app);
        });
    }
}
