<?php

namespace Silicone\Component\Database;
/**
 *
 * @method bindParam($parameter, $variable, $data_type = PDO::PARAM_STR, $length = 255, $driver_options = array())
 * @method execute($args = array())
 * @method fetch($fetch_style = PDO::FETCH_BOTH, $cursor_orientation = PDO::FETCH_ORI_NEXT, $cursor_offset = 0)
 * @method fetchAll($fetch_style = PDO::FETCH_BOTH, $fetch_argument = null, $ctor_args = array() )
 * @method fetchColumn($column_number = 0)
 * @method setFetchMode($mode)
 */
class Statement
{
    /** @var \PDOStatement */
    private $_stmt;

    /**
     * Constructor
     *
     * @param \PDOStatement $stmt
     */
    public function __construct($stmt)
    {
        $this->_stmt = $stmt;
    }

    /**
     * Nativie PDOStatement's method proxy.
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->_getStatement(), $method), $args);
    }

    /**
     *
     * @param $args
     */
    public function bindParams($args)
    {
        foreach ($args as $key => $val) {
            $this->bindParam($key, $val);
        }
    }

    /**
     * @return \PDOStatement
     */
    private function _getStatement()
    {
        return $this->_stmt;
    }
}
