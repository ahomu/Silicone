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
     * Register specified domain's ActionController.
     * If ConrollerProvider exists in the domain, when Provider will be autoloaing.
     *
     * @param string $domainName Functional domain namespace.
     * @param string $mountPath  Mount path for ControllerProvider.
     */
    public function import($domainName, $mountPath = '')
    {
        $domainName = ucwords(strtolower($domainName));
        $this->app->autoloader->registerNamespace($domainName, DIR_DOMAINS);
        $this->namespaces[$domainName] = new ActionController($domainName, $this->app);

        $controllerName = $domainName.'\\ControllerProvider';
        if (class_exists($controllerName)) {
            $mountPath = $mountPath ? $mountPath : '/'.strtolower($domainName);
            $this->app->mount($mountPath, new $controllerName());
        }
    }

    /**
     * Call specified domain's ActionController.
     *
     * @param string $domainName
     * @return bool|\Silicone\Component\Domain\ActionController
     */
    public function call($domainName)
    {
        $domainName = ucwords(strtolower($domainName));
        return isset($this->namespaces[$domainName]) ? $this->namespaces[$domainName] : false;
    }
}
