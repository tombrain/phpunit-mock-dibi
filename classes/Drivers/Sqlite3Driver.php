<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Cz\PHPUnit\MockDB,
    Cz\PHPUnit\SQL,
    DateTime,
    DateTimeInterface,
    Dibi\DateTime as DibiDateTime,
    Dibi\Drivers,
    Dibi\NotImplementedException,
    Dibi\NotSupportedException;

/**
 * Sqlite3Driver
 * 
 * @author   czukowski
 * @license  MIT License
 */
class Sqlite3Driver extends Drivers\Sqlite3Driver implements
    MockDB\DatabaseDriverInterface,
    SQL\DatabaseDriverInterface
{
    use MockQueryConnectionTrait;
    use MockQueryDriverTrait;
    use MockQueryResultDriverTrait;

    /**
     * @var  string
     */
    private $fmtDate;
    /**
     * @var  string
     */
    private $fmtDateTime;

    /**
     * @param  array  $config
     */
    public function connect(array & $config)
    {
        $this->fmtDate = isset($config['formatDate']) ? $config['formatDate'] : 'U';
        $this->fmtDateTime = isset($config['formatDateTime']) ? $config['formatDateTime'] : 'U';
    }

    /**
     * @param  mixed  $savepoint
     */
    public function begin($savepoint = NULL)
    {
        $this->addExecutedQuery($savepoint ? "SAVEPOINT $savepoint" : 'BEGIN');
    }

    /**
     * @param  mixed  $savepoint
     */
    public function commit($savepoint = NULL)
    {
        $this->addExecutedQuery($savepoint ? "RELEASE SAVEPOINT $savepoint" : 'COMMIT');
    }

    /**
     * @param  mixed  $savepoint
     */
    public function rollback($savepoint = NULL)
    {
        $this->addExecutedQuery($savepoint ? "ROLLBACK TO SAVEPOINT $savepoint" : 'ROLLBACK');
    }

    /**
     * A copy of parent method due to usage of private property.
     * 
     * @param   DateTime|DateTimeInterface|string|int
     * @return  string
     */
    public function escapeDate($value)
    {
        if ( ! $value instanceof DateTime && ! $value instanceof DateTimeInterface) {
            $value = new DibiDateTime($value);
        }
        return $value->format($this->fmtDate);
    }

    /**
     * A copy of parent method due to usage of private property.
     * 
     * @param   DateTime|DateTimeInterface|string|int
     * @return  string
     */
    public function escapeDateTime($value)
    {
        if ( ! $value instanceof DateTime && ! $value instanceof DateTimeInterface) {
            $value = new DibiDateTime($value);
        }
        return $value->format($this->fmtDateTime);
    }

    /**
     * @param   string   $value
     * @param   integer  $pos
     * @return  string
     */
    public function escapeLike($value, $pos)
    {
        return ($pos <= 0 ? "'%" : "'")
            .addcslashes($this->escapeString($value), '%_\\')
            .($pos >= 0 ? "%'" : "'")
            . " ESCAPE '\\'";
    }

    /**
     * Cheap and dirty replacement for `SQLite3::escapeString`.
     * 
     * @param   string  $value
     * @return  string
     */
    private function escapeString($value)
    {
        return str_replace("'", "''", $value);
    }

    /**
     * @param   string  $value
     * @return  string
     */
    public function escapeText($value)
    {
        return "'".$this->escapeString($value)."'";
    }

    /**
     * @throws  NotSupportedException
     */
    public function getRowCount()
    {
        // Parent class will throw exception.
        return parent::getRowCount();
    }

    /**
     * @throws  NotSupportedException
     */
    public function seek($row)
    {
        // Parent class will throw exception.
        return parent::seek($row);
    }

    /**
     * @throws  NotImplementedException
     */
    public function registerFunction($name, callable $callback, $numArgs = -1)
    {
        throw new NotImplementedException('No user-defined functions for mock DB connection');
    }

    /**
     * @throws  NotImplementedException
     */
    public function registerAggregateFunction($name, callable $rowCallback, callable $agrCallback, $numArgs = -1)
    {
        throw new NotImplementedException('No user-defined functions for mock DB connection');
    }
}
