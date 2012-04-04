<?php

namespace Silicone\Component\Database;
/**
 *
 * @method execute($args = array())
 * @method array fetchAll($fetch_style = PDO::FETCH_BOTH, $fetch_argument = null, $ctor_args = array() )
 * @method array fetch($fetch_style = PDO::FETCH_BOTH, $cursor_orientation = PDO::FETCH_ORI_NEXT, $cursor_offset = 0)
 * @method array fetchColumn($column_number = 0)
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
     * @return \PDOStatement
     */
    private function _getStatement()
    {
        return $this->_stmt;
    }
}
