<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotSupportedException;

/**
 * MySqliResultTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MySqliResultTest extends Testcase
{
   /**
     * @dataProvider  provideUnsupportedMethods
     */
    public function testUnsupportedMethods($method, $arguments)
    {
        $object = $this->createObject();
        $this->expectException(NotSupportedException::class);
        call_user_func_array([$object, $method], $arguments);
    }

    public function provideUnsupportedMethods()
    {
        return [
            ['getResultResource', []],
        ];
    }

    /**
     * @return  MySqliResult
     */
    private function createObject()
    {
        return new MySqliResult(NULL);
    }
}
