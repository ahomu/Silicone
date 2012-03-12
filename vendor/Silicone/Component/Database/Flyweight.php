<?php

namespace Silicone\Component\Database;

class Flyweight
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
     * Call PDO.
     *
     * @param string $id
     * @return \PDO
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
    public function connect($config, $id)
    {
        $dsn    = $config['engine'].':dbname='.$config['name'].';host='.$config['host'];
        $user   = $config['user'];
        $passwd = $config['passwd'];

        /* @var \PDO $connection */
        $connection = $this->_connections[$id] = new \PDO($dsn, $user, $passwd);
        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Preserve database connection configuration.
     *
     * @param array  $config
     * @param string $id
     */
    public function preserve($config, $id)
    {
        $this->_connections[$id] = $config;
    }
}
