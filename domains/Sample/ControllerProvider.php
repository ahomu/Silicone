<?php

namespace Sample;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $this->_initializer($app);
        $controllers = new ControllerCollection();

//        $controllers->get('/', function (Application $app) {
//            return $app->redirect('/hello');
//        });

        return $controllers;
    }

    private function _initializer(Application $app)
    {

    }
}
