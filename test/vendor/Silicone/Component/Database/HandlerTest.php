<?php

namespace Silicone\Component\Database;

class HandlerTestSilicone extends \PHPUnit_Extensions_Database_TestCase
{
    protected $backupGlobalsBlacklist = array('app');

    /** @var \Silicone\Component\Database\Handler */
    protected $subject;

    /** @var \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection */
    protected $conn = null;

    public function setUp()
    {
        $this->subject = $GLOBALS['app']->db->call();
        parent::setUp();
    }

    /**
     * @see \PHPUnit_Extensions_Database_TestCase::getConnection()
     * @return \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
     */
    public function getConnection()
    {
        if (is_null($this->conn)) {
            $this->conn = $this->createDefaultDBConnection($this->subject->getPdo());
        }
        return $this->conn;
    }

    /**
     * @see \PHPUnit_Extensions_Database_TestCase::getDataSet()
     * @return \PHPUnit_Extensions_Database_DataSet_CsvDataSet
     */
    public function getDataSet() {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_CsvDataSet();
        $dataset->addTable('test', DIR_FIXTURES.str_replace('\\', '_', get_class($this->subject)).'.csv');
        return $dataset;
    }

    public function testQuery()
    {
        $this->assertInternalType('array', $this->subject->query('SELECT * FROM `test`', 'all'));

        $this->assertInternalType('array', $this->subject->query('SELECT * FROM `test`', 'row'));

        $this->assertInternalType('string', $this->subject->query('SELECT * FROM `test`', 'one'));

        $this->assertInstanceOf('Silicone\\Component\\Database\\Statement', $this->subject->query('SELECT * FROM `test`', 'fetch'));

        $this->assertTrue($this->subject->query('INSERT INTO `test` VALUES(6, "six")', 'exec'));

        $this->setExpectedException('\\PDOException');
        $this->subject->query('INSERT INTO `none` VALUES(6, "six")', 'exec');
    }

    public function testGetPDO()
    {
        $this->assertInstanceOf('PDO', $this->subject->getPDO());
    }
}
