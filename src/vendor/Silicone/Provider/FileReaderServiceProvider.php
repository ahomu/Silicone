<?php

namespace Silicone\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Silicone\Component\FileReader\FileReaderFactory;

/**
 * Silicone FileReader component Provider.
 *
 * @author Ayumu Sato <mail@ayumusato.com>
 */
class FileReaderServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['file_reader'] = $app->share(function () use ($app) {
            $factory = new FileReaderFactory();
            $factory->registerReader('xml', '\\Silicone\\Component\\FileReader\\XMLReader');
            $factory->registerReader('csv', '\\Silicone\\Component\\FileReader\\CSVReader');
            return $factory;
        });
    }
}
