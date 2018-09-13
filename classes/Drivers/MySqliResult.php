<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\Drivers,
    Dibi\NotSupportedException,
    mysqli_result;

/**
 * MySqliResult
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MySqliResult extends Drivers\MySqliResult
{
    use MockQueryResultDriverTrait;

    /**
     * @throws  NotSupportedException
     */
    public function getResultResource(): mysqli_result
    {
        throw new NotSupportedException('Native result resource unavailable for mock DB connection');
    }
}
