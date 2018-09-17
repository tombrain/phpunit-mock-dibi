<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Cz\PHPUnit\SQL,
    Dibi\Drivers,
    Dibi\NotImplementedException,
    Dibi\Reflector;

/**
 * OdbcDriver
 * 
 * @author   czukowski
 * @license  MIT License
 */
class OdbcDriver extends Drivers\OdbcDriver implements
    DatabaseDriverInterface,
    SQL\DatabaseDriverInterface
{
    use MockQueryConnectionTrait;
    use MockQueryDriverTrait;

    /**
     * @var  boolean
     */
    private $inTransaction = FALSE;

    /**
     * @param  mixed  $savepoint
     */
    public function begin(?string $savepoint = NULL): void
    {
        $this->inTransaction = TRUE;
    }

    /**
     * @param  mixed  $savepoint
     */
    public function commit(?string $savepoint = NULL): void
    {
        $this->inTransaction = FALSE;
    }

    /**
     * @param  mixed  $savepoint
     */
    public function rollback(?string $savepoint = NULL): void
    {
        $this->inTransaction = FALSE;
    }

    /**
     * @return  boolean
     */
    public function inTransaction(): bool
    {
        return $this->inTransaction;
    }

    /**
     * @return  OdbcResult
     */
    public function createResultDriver($resultSet): Drivers\OdbcResult
    {
        return new OdbcResult($resultSet);
    }

    /**
     * @throws  NotSupportedException
     */
    public function getInsertId(?string $sequence): ?int
    {
        // Parent class will throw exception.
        return parent::getInsertId($sequence);
    }

    /**
     * @throws  NotImplementedException
     */
    public function getReflector(): Reflector
    {
        throw new NotImplementedException('No schema info for mock DB connection');
    }
}
