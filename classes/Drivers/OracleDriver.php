<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Cz\PHPUnit\SQL,
    Dibi\Drivers,
    ReflectionProperty;

/**
 * OracleDriver
 * 
 * @author   czukowski
 * @license  MIT License
 */
class OracleDriver extends Drivers\OracleDriver implements
    DatabaseDriverInterface,
    SQL\DatabaseDriverInterface
{
    use MockQueryConnectionTrait;
    use MockQueryDriverTrait;

    /**
     * @param   mixed  $sequence
     * @return  integer|NULL
     */
    public function getInsertId(?string $sequence): ?int
    {
        $this->addExecutedQuery("SELECT $sequence.CURRVAL AS ID FROM DUAL");
        return $this->lastInsertId ? : NULL;
    }

    /**
     * @param  string  $savepoint
     */
    public function begin(string $savepoint = NULL): void
    {
        // Do nothing.
    }

    /**
     * @param  string  $savepoint
     */
    public function commit(string $savepoint = NULL): void
    {
        // Do nothing.
    }

    /**
     * @param  string  $savepoint
     */
    public function rollback(string $savepoint = NULL): void
    {
        // Do nothing.
    }

    /**
     * @param   mixed  $resource
     * @return  OracleResult
     */
    public function createResultDriver($resultSet): Drivers\OracleResult
    {
        return new OracleResult($resultSet);
    }

    /**
     * @param  boolean  $value
     */
    public function setUseNativeDate(bool $value): void
    {
        $property = new ReflectionProperty(Drivers\OracleDriver::class, 'nativeDate');
        $property->setAccessible(TRUE);
        $property->setValue($this, $value);
    }
}
