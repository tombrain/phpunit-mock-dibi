<?php
namespace Cz\PHPUnit\MockDibi\Doubles;

use Cz\PHPUnit\MockDB\Mock;

/**
 * MockDouble
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MockDouble extends Mock
{
    /**
     * @var  Invocation
     */
    public $invoked;

    /**
     * Note: no strict type check here.
     * 
     * @param   Invocation  $invocation
     * @return  Invocation
     */
    public function invoke($invocation)
    {
        $this->invoked = $invocation;
        return $invocation;
    }
}
