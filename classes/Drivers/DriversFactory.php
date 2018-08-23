<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

/**
 * DriversFactory
 * 
 * @author  czukowski
 */
class DriversFactory
{
    /**
     * @return  FirebirdDriver
     */
    public function createFirebirdDriver()
    {
        return new FirebirdDriver;
    }

    /**
     * @return  MsSqlDriver
     */
    public function createMsSqlDriver()
    {
        return new MsSqlDriver;
    }

    /**
     * @return  MySqlDriver
     */
    public function createMySqlDriver()
    {
        return new MySqlDriver;
    }

    /**
     * @return  MySqliDriver
     */
    public function createMySqliDriver()
    {
        return new MySqliDriver;
    }

    /**
     * @return  OdbcDriver
     */
    public function createOdbcDriver()
    {
        return new OdbcDriver;
    }

    /**
     * @param   string  $driverName
     * @return  PdoDriver
     */
    public function createPdoDriver($driverName)
    {
        return new PdoDriver($driverName);
    }

    /**
     * @return  PostgreDriver
     */
    public function createPostgreDriver()
    {
        return new PostgreDriver;
    }

    /**
     * @return  Sqlite3Driver
     */
    public function createSqlite3Driver()
    {
        return new Sqlite3Driver;
    }

    /**
     * @return  SqlsrvDriver
     */
    public function createSqlsrvDriver()
    {
        return new SqlsrvDriver;
    }
}
