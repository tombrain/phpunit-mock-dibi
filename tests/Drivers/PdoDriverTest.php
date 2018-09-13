<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotSupportedException,
    PDOStatement;

/**
 * PdoDriverTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class PdoDriverTest extends Testcase
{
    /**
     * @dataProvider  provideCreateResultDriver
     */
    public function testCreateResultDriver($driverName)
    {
        $object = $this->createObject($driverName);
        $resultSet = $this->createMock(PDOStatement::class);
        $actual = $object->createResultDriver($resultSet);
        $this->assertInstanceOf(PdoResult::class, $actual);
        $this->assertSame(
            $driverName,
            $this->getReflectionProperty(PdoResult::class, 'driverName')
                ->getValue($actual)
        );
        $this->assertSame(
            $resultSet,
            $this->getReflectionProperty(PdoResult::class, 'resultSet')
                ->getValue($actual)
        );
    }

    public function provideCreateResultDriver()
    {
        return [
            ['sqlite'],
        ];
    }

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
     * @dataProvider  provideReturnNullMethods
     */
    public function testReturnNullMethods($driverName, $methodName, $arguments)
    {
        $object = $this->createObject($driverName);
        $actual = call_user_func_array([$object, $methodName], $arguments);
        $this->assertNull($actual);
    }

    public function provideReturnNullMethods()
    {
        return [
            ['pgsql', 'getResource', []],
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
