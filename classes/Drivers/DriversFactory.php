<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

/**
 * DriversFactory
 * 
 * @author   czukowski
 * @license  MIT License
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
     * @param   boolean  $nativeDate
     * @return  OracleDriver
     */
    public function createOracleDriver(bool $nativeDate = TRUE)
    {
        $driver = new OracleDriver;
        $driver->setUseNativeDate($nativeDate);
        return $driver;
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
     * @return  PdoDriver
     */
    public function createPdoDblibDriver()
    {
        return $this->createPdoDriver('dblib');
    }

    /**
     * @return  PdoDriver
     */
    public function createPdoMysqlDriver()
    {
        return $this->createPdoDriver('mysql');
    }

    /**
     * @return  PdoDriver
     */
    public function createPdoMssqlDriver()
    {
        return $this->createPdoDriver('mssql');
    }

    /**
     * @return  PdoDriver
     */
    public function createPdoOciDriver()
    {
        return $this->createPdoDriver('oci');
    }

    /**
     * @return  PdoDriver
     */
    public function createPdoOdbcDriver()
    {
        return $this->createPdoDriver('odbc');
    }

    /**
     * @return  PdoDriver
     */
    public function createPdoPgsqlDriver()
    {
        return $this->createPdoDriver('pgsql');
    }

    /**
     * @return  PdoDriver
     */
    public function createPdoSqliteDriver()
    {
        return $this->createPdoDriver('sqlite');
    }

    /**
     * @return  PdoDriver
     */
    public function createPdoSqlsrvDriver()
    {
        return $this->createPdoDriver('sqlsrv');
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
