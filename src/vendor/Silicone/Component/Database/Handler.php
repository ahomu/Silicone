<?php

namespace Silicone\Component\Database;

use \PDO;

class Handler
{
    /** @var \PDO */
    private $_pdo;

    /** @var array */
    private $_fetches;

    /** @var string */
    private $_dsn;

    /** @var string */
    private $_user;

    /** @var string */
    private $_passwd;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $this->_dsn    = $config['dsn'];
        $this->_user   = $config['user'];
        $this->_passwd = $config['passwd'];

        $this->_fetches= array();

        /* @var \PDO $connection */
        $this->_pdo = new PDO($this->_dsn, $this->_user, $this->_passwd);
        $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Send raw completion query and fetch results.
     *
     * @param string $sql
     * @param string $opt
     * @return mixed
     */
    public function query($sql, $opt = 'all')
    {
        $stmt = $this->_createStatement($sql);
        $res  = null;
        switch ($opt) {
            case 'all'  :
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
            case 'row'  :
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                break;
            case 'one'  :
                $res = $stmt->fetchColumn(0);
                break;
            case 'exec' :
                $res = $stmt->execute();
                break;
            case 'fetch':
                $stmt->execute();
                $res = $stmt;
                break;
            default     :
                break;
        }
        return $res;
    }

    /**
     * @param string $sql
     * @return \Silicone\Component\Database\Statement
     */
    private function _createStatement($sql)
    {
        return new Statement($this->_pdo->query($sql));
    }

    /**
     * @return \PDO
     */
    public function getPDO()
    {
        return $this->_pdo;
    }
}
