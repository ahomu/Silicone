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
        $this->_pdo = new PDO($this->_dsn, $this->_user, $this->_passwd, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`"
        ));
        $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
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
        $stmt = $this->_wrapStatement($this->_pdo->query($sql));
        $res  = null;

        switch ($opt) {
            case 'all'  :
                $res = $stmt->fetchAll();
                break;
            case 'row'  :
                $res = $stmt->fetch();
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
     * Get prepared statement.
     *
     * @param string $sql
     * @param array $options
     * @return \Silicone\Component\Database\Statement
     */
    public function prepare($sql, $options = array())
    {
        return $this->_wrapStatement($this->_pdo->prepare($sql, $options));
    }

    /**
     * @return \PDO
     */
    public function getPDO()
    {
        return $this->_pdo;
    }

    /**
     * @param \PDOStatement $stmt
     * @return \Silicone\Component\Database\Statement
     */
    private function _wrapStatement($stmt)
    {
        return new Statement($stmt);
    }
}
