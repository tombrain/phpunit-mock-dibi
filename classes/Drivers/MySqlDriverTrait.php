<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotImplementedException;

/**
 * MySqlDriverTrait
 * 
 * @author   czukowski
 * @license  MIT License
 */
trait MySqlDriverTrait
{
    /**
     * @param  mixed  $savepoint
     */
    public function begin(?string $savepoint = NULL): void
    {
        $this->addExecutedQuery($savepoint ? "SAVEPOINT $savepoint" : 'START TRANSACTION');
    }

    /**
     * @param  mixed  $savepoint
     */
    public function commit(?string $savepoint = NULL): void
    {
        $this->addExecutedQuery($savepoint ? "RELEASE SAVEPOINT $savepoint" : 'COMMIT');
    }

    /**
     * @param  mixed  $savepoint
     */
    public function rollback(?string $savepoint = NULL): void
    {
        $this->addExecutedQuery($savepoint ? "ROLLBACK TO SAVEPOINT $savepoint" : 'ROLLBACK');
    }

    /**
     * @param   string  $value
     * @return  string
     */
    public function escapeBinary(string $value): string
    {
        return MySqlEscapingHelper::escapeBinary($value);
    }

    /**
     * @param   string  $value
     * @return  string
     */
    public function escapeText(string $value): string
    {
        return MySqlEscapingHelper::escapeText($value);
    }

    /**
     * @throws  NotImplementedException
     */
    public function getInfo(): array
    {
        throw new NotImplementedException('No query info for mock DB connection');
    }

    /**
     * @param  string  $sql
     */
    abstract public function addExecutedQuery($sql);
}
