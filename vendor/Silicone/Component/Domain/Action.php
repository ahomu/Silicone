<?php

namespace Silicone\Component\Domain;

abstract class Action
{
    public $app;

    /**
     * @abstract
     * @param array $params
     * @param \Silicone\Application $app
     */
    abstract public function boot($params, $app);
}
