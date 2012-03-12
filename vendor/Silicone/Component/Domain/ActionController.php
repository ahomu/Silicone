<?php

namespace Silicone\Component\Domain;

class ActionController extends Action
{
    /**
     * @var string $_domainName
     */
    private $_domainName;

    /**
     * Constructor
     *
     * @param $domainName
     */
    public function __construct($domainName)
    {
        $this->_domainName = $domainName;
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
     * @return bool|\Silicone\Component\Domain\Action
     */
    public function action($path)
    {
        $path = $this->_domainName.'.'.trim($path, '.');

        $className = implode('\\', array_map(function($v) {
            return ucwords($v);
        }, explode('.', $path)));

        if (class_exists($className)) {
            return new $className();
        }

        return false;
    }
}
