<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotSupportedException;

/**
 * Sqlite3ResultTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class Sqlite3ResultTest extends Testcase
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
            ['getRowCount', []],
            ['seek', [0]],
        ];
    }

    /**
     * @return  Sqlite3Result
     */
    private function createObject()
    {
        return new Sqlite3Result(NULL);
    }
}
