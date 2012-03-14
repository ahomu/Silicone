<?php

namespace Silicone\Component\Domain;

class ActionController
{
    /**
     * @var string $_domainName
     */
    private $_domainName;

    /**
     * @var \Silicone\Application $_app
     */
    private $_app;

    /**
     * Constructor
     *
     * @param $domainName
     * @param \Silicone\Application $app
     */
    public function __construct($domainName, $app)
    {
        $this->_domainName = $domainName;
        $this->_app        = $app;
    }

    /**
     * toString when get domain name.
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->_domainName;
    }

    /**
     * Traversal & get Action's instance.
     *
     * @param string $path
     * @param array $params
     * @return bool|mixed
     */
    public function action($path, $params = array())
    {
        $path = $this->_domainName.'.'.trim($path, '.');

        $className = implode('\\', array_map(function($v) {
            return ucwords($v);
        }, explode('.', $path)));

        if (class_exists($className)) {
            /**
             * @var \Silicone\Component\Domain\Action $action
             */
            $action = new $className();
            if ($action instanceof Action) {
                return $action->boot($params, $this->_app);
            }
        }

        return false;
    }
}
