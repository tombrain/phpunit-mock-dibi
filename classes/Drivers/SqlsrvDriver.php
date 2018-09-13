<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Cz\PHPUnit\SQL,
    Dibi\Drivers,
    ReflectionProperty;

/**
 * SqlsrvDriver
 * 
 * @author   czukowski
 * @license  MIT License
 */
class SqlsrvDriver extends Drivers\SqlsrvDriver implements
    DatabaseDriverInterface,
    SQL\DatabaseDriverInterface
{
    use MockQueryConnectionTrait;
    use MockQueryDriverTrait;

    /**
     * @param  string  $config
     */
    public function connect(array & $config)
    {
        $version = isset($config['version']) ? $config['version'] : '11';
        $this->setVersion($version);
    }

    /**
     * @param   mixed  $sequence
     * @return  mixed
     */
    public function getInsertId(?string $sequence): ?int
    {
        $this->addExecutedQuery('SELECT SCOPE_IDENTITY()');
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
     * @param  string  $value
     */
    public function setVersion($value)
    {
        $version = new ReflectionProperty(Drivers\SqlsrvDriver::class, 'version');
        $version->setAccessible(TRUE);
        $version->setValue($this, $value);
    }

    /**
     * @param   mixed  $resultSet
     * @return  SqlsrvResult
     */
    public function createResultDriver($resultSet): Drivers\SqlsrvResult
    {
        return new SqlsrvResult($resultSet);
    }
}
