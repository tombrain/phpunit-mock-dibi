<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\Drivers,
    Dibi\NotSupportedException,
    PDOStatement;

/**
 * PdoResult
 * 
 * @author   czukowski
 * @license  MIT License
 */
class PdoResult extends Drivers\PdoResult
{
    use MockQueryResultDriverTrait;

    /**
     * @var  string
     */
    private $driverName;

    /**
     * @param  mixed   $resultSet
     * @param  string  $driverName
     */
    public function __construct($resultSet, $driverName)
    {
        $this->setResultResource($resultSet);
        $this->driverName = $driverName;
        // No calling parent constructor, it would fail if PDO extension is not enabled.
    }

    /**
     * @throws  NotSupportedException
     */
    public function getResultResource(): ?PDOStatement
    {
        throw new NotSupportedException('Native result resource unavailable for mock DB connection');
    }
}
