<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Cz\PHPUnit\MockDibi,
    Cz\PHPUnit\SQL\DatabaseDriverInterface,
    ReflectionProperty;

/**
 * Testcase
 * 
 * @author   czukowski
 * @license  MIT License
 */
abstract class Testcase extends MockDibi\Testcase
{
    /**
     * @param  DatabaseDriverInterface  $object
     * @param  string                   $expected
     */
    protected function assertExecutedQuery(DatabaseDriverInterface $object, $expected)
    {
        $queries = $object->getExecutedQueries();
        $this->assertCount(1, $queries);
        $this->assertSame($expected, reset($queries));
    }

    /**
     * @param   string|object  $class
     * @param   string         $name
     * @return  ReflectionProperty
     */
    protected function getReflectionProperty($class, $name)
    {
        $property = new ReflectionProperty($class, $name);
        $property->setAccessible(TRUE);
        return $property;
    }

    /**
     * @return  DriversFactory
     */
    protected function getDriversFactory()
    {
        return new DriversFactory;
    }
}
