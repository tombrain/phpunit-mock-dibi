<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Cz\PHPUnit\SQL,
    Dibi\Drivers;

/**
 * PdoDriver
 * 
 * @author   czukowski
 * @license  MIT License
 */
class PdoDriver extends Drivers\PdoDriver implements
    DatabaseDriverInterface,
    SQL\DatabaseDriverInterface
{
    use MockQueryConnectionTrait;
    use MockQueryDriverTrait;
    use MockQueryResultDriverTrait;

    /**
     * @param  string  $driverName
     */
    public function __construct($driverName)
    {
        $config = [
            'resource' => new PdoConnectionDouble($driverName),
        ];
        parent::__construct($config);
    }

    /**
     * @param  mixed  $savepoint
     */
    public function begin($savepoint = NULL)
    {
        // Empty implementation.
    }

    /**
     * @param  mixed  $savepoint
     */
    public function commit($savepoint = NULL)
    {
        // Empty implementation.
    }

    /**
     * @param  mixed  $savepoint
     */
    public function rollback($savepoint = NULL)
    {
        // Empty implementation.
    }
}
