<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Cz\PHPUnit\SQL,
    Dibi\Drivers,
    Dibi\NotImplementedException;

/**
 * PostgreDriver
 * 
 * @author   czukowski
 * @license  MIT License
 */
class PostgreDriver extends Drivers\PostgreDriver implements
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
     * @param   mixed  $sequence
     * @return  integer|NULL
     */
    public function getInsertId(?string $sequence): ?int
    {
        $this->addExecutedQuery($sequence === NULL ? 'SELECT LASTVAL()' : "SELECT CURRVAL('$sequence')");
        return $this->lastInsertId ? : NULL;
    }

    /**
     * @param  mixed  $savepoint
     */
    public function begin(string $savepoint = NULL): void
    {
        $this->inTransaction = TRUE;
        $this->addExecutedQuery($savepoint ? "SAVEPOINT $savepoint" : 'START TRANSACTION');
    }

    /**
     * @param  mixed  $savepoint
     */
    public function commit(string $savepoint = NULL): void
    {
        $this->inTransaction = FALSE;
        $this->addExecutedQuery($savepoint ? "RELEASE SAVEPOINT $savepoint" : 'COMMIT');
    }

    /**
     * @param  mixed  $savepoint
     */
    public function rollback(string $savepoint = NULL): void
    {
        $this->inTransaction = FALSE;
        $this->addExecutedQuery($savepoint ? "ROLLBACK TO SAVEPOINT $savepoint" : 'ROLLBACK');
    }

    /**
     * @return  boolean
     */
    public function inTransaction(): bool
    {
        return $this->inTransaction;
    }

    /**
     * @param   mixed  $resultSet
     * @return  PostgreResult
     */
    public function createResultDriver($resultSet): Drivers\PostgreResult
    {
        return new PostgreResult($resultSet);
    }

    /**
     * A replacement for `pg_escape_bytea`.
     * 
     * @param   string  $value
     * @return  string
     */
    public function escapeBinary(string $value): string
    {
        return PostgreEscapingHelper::escapeBinary($value);
    }

    /**
     * Adapted version of the parent class' method to avoid calls to `pg_escape_string`.
     * 
     * @param   string  $value
     * @param   string  $pos
     * @return  string
     */
    public function escapeLike(string $value, int $pos): string
    {
        return ($pos <= 0 ? "'%" : "'")
            .strtr($value, ['%' => '\\%', '_' => '\\_', '\\' => '\\\\'])
            .($pos >= 0 ? "%'" : "'");
    }

    /**
     * A cheap and dirty replacement for `pg_escape_string`.
     * 
     * @param   string  $value
     * @return  string
     */
    public function escapeText(string $value): string
    {
        return PostgreEscapingHelper::escapeText($value);
    }

    /**
     * A replacement for `pg_unescape_bytea`.
     * 
     * @param   string  $value
     * @return  string
     */
    public function unescapeBinary(string $value): string
    {
        return PostgreEscapingHelper::unescapeBinary($value);
    }

    /**
     * @throws  NotImplementedException
     */
    public function ping(): bool
    {
        throw new NotImplementedException('No pinging mock DB connection');
    }

    /**
     * @throws  NotImplementedException
     */
    public function getTables(): array
    {
        throw new NotImplementedException('Parent class method uses extention functions');
    }

    /**
     * @param   string  $table
     * @throws  NotImplementedException
     */
    public function getColumns($table): array
    {
        throw new NotImplementedException('Parent class method uses extention functions');
    }
}
