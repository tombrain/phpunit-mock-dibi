<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotSupportedException;

/**
 * FirebirdResultTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class FirebirdResultTest extends Testcase
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
            ['seek', [0]],
        ];
    }

    /**
     * @return  FirebirdResult
     */
    private function createObject()
    {
        return new FirebirdResult(NULL);
    }
}
