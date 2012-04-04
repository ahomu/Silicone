<?php

namespace Silicone\Component\Database;

class HandlerFactory
{
    private $_connections = array();

    /**
     * Constructor
     *
     * @param array  $config
     * @param string $id
     */
    public function __construct($config, $id = '__default__')
    {
        $this->preserve($config, $id);
    }

    /**
     * Call PDO Wrapper.
     *
     * @param string $id
     * @return \Silicone\Component\Database\Handler
     */
    public function call($id = '__default__')
    {
        $configOrResource = $this->_connections[$id];

        if (is_array($configOrResource)) {
            $this->connect($configOrResource, $id);
        }

        return $this->_connections[$id];
    }

    /**
     * Connect database.
     *
     * @param array  $config
     * @param string $id
     */
    protected function connect($config, $id)
    {
        $this->_connections[$id] = new Handler($config);
    }

    /**
     * Preserve database connection configuration.
     *
     * @param array  $config
     * @param string $id
     */
    protected function preserve($config, $id)
    {
        $this->_connections[$id] = $config;
    }
}
