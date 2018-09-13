<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Cz\PHPUnit\SQL,
    Dibi\Drivers,
    mysqli;

/**
 * MySqliDriver
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MySqliDriver extends Drivers\MySqliDriver implements
    DatabaseDriverInterface,
    SQL\DatabaseDriverInterface
{
    use MockQueryConnectionTrait;
    use MockQueryDriverTrait;
    use MySqlDriverTrait;

    /**
     * @return  MySqliResult
     */
    public function createResultDriver($resultSet): Drivers\MySqliResult
    {
        return new MySqliResult($resultSet);
    }

    /**
     * @return  NULL
     */
    public function getResource(): ?mysqli
    {
        // Do not throw exception here, method called by `Dibi\Connection` destructor.
        return NULL;
    }
}
