<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

/**
 * PdoDriverTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class PdoDriverTest extends Testcase
{
    /**
     * @dataProvider  provideEmptyMethods
     */
    public function testEmptyMethods($driverName, $methodName)
    {
        $object = $this->createObject($driverName);
        $actual = call_user_func([$object, $methodName]);
        $this->assertNull($actual);
    }

    public function provideEmptyMethods()
    {
        return [
            ['odbc', 'begin'],
            ['mysql', 'commit'],
            ['oci', 'rollback'],
        ];
    }

    /**
     * @param   string  $driverName
     * @return  PdoDriver
     */
    private function createObject($driverName)
    {
        return $this->getDriversFactory()
            ->createPdoDriver($driverName);
    }
}
