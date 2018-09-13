<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\Drivers,
    Dibi\NotSupportedException,
    SQLite3Result as NativeSQLite3Result;

/**
 * Sqlite3Result
 * 
 * @author   czukowski
 * @license  MIT License
 */
class Sqlite3Result extends Drivers\Sqlite3Result
{
    use MockQueryResultDriverTrait;

    /**
     * @throws  NotSupportedException
     */
    public function getResultResource(): NativeSQLite3Result
    {
        throw new NotSupportedException('Native result resource unavailable for mock DB connection');
    }

    /**
     * @throws  NotSupportedException
     */
    public function getRowCount(): int
    {
        // Parent class will throw exception.
        return parent::getRowCount();
    }

    /**
     * @throws  NotSupportedException
     */
    public function seek(int $row): bool
    {
        // Parent class will throw exception.
        return parent::seek($row);
    }
}
