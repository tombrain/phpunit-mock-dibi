<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotImplementedException;

/**
 * MySqlDriverTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MySqlDriverTest extends Testcase
{
    /**
     * @dataProvider  provideNotImplementedMethods
     */
    public function testNotImplementedMethods($method)
    {
        $object = $this->createObject();
        $this->expectException(NotImplementedException::class);
        call_user_func([$object, $method]);
    }

    public function provideNotImplementedMethods()
    {
        return [
            ['getInfo'],
        ];
    }

    /**
     * @return  MySqlDriver
     */
    private function createObject()
    {
        return $this->getDriversFactory()
            ->createMySqlDriver();
    }
}
