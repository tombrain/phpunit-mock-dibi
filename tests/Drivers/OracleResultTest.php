<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotImplementedException,
    Dibi\NotSupportedException;

/**
 * OracleResultTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class OracleResultTest extends Testcase
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
            ['getRowCount', []],
        ];
    }

    /**
     * @dataProvider  provideUnimplementedMethods
     */
    public function testUnimplementedMethods($method, $arguments)
    {
        $object = $this->createObject();
        $this->expectException(NotImplementedException::class);
        call_user_func_array([$object, $method], $arguments);
    }

    public function provideUnimplementedMethods()
    {
        return [
            ['seek', [0]],
        ];
    }

    /**
     * @return  OracleResult
     */
    private function createObject()
    {
        return new OracleResult(NULL);
    }
}
