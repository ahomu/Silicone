<?php

namespace Silicone\Component\Domain;

class ActionControllerCollection
{
    /**
     * @var array $namespaces
     */
    public $namespaces = array();

    /**
     * @var \Silicone\Application $app
     */
    public $app;

    /**
     * Constructor
     *
     * @param \Silicone\Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Alias to 'call' method.
     *
     * @param $prop
     * @return bool|ActionController
     */
    public function __get($prop)
    {
        return $this->call($prop);
    }

    /**
     * Register specified domain's ActionController.
     *
     * @param $domainName
     * @return void
     */
    public function import($domainName)
    {
        $this->app->autoloader->registerNamespace($domainName, DIR_DOMAINS);
        $this->namespaces[$domainName] = new ActionController($domainName);
    }

    /**
     * Call specified domain's ActionController.
     *
     * @param $domainName
     * @return bool|ActionController
     */
    public function call($domainName)
    {
        return isset($this->namespaces[$domainName]) ? $this->namespaces[$domainName] : false;
    }
}
