<?php
namespace Cz\PHPUnit\MockDibi;

use Cz\PHPUnit\MockDibi\Drivers\DriversFactory,
    Exception,
    PHPUnit\Framework\TestCase as FrameworkTestCase,
    ReflectionClass,
    ReflectionMethod;

/**
 * Testcase
 * 
 * @author   czukowski
 * @license  MIT License
 */
abstract class Testcase extends FrameworkTestCase
{
    /**
     * @return  array
     */
    public function createDriversDataProvider(...$arguments)
    {
        $factory = $this->getDriversFactory();
        $class = new ReflectionClass($factory);
        $testcases = [];
        foreach ($class->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getNumberOfParameters() || substr($method->getName(), 0, 6) !== 'create') {
                continue;
            }
            $key = substr($method->getName(), 6);
            $testcases[$key] = $arguments;
            array_unshift($testcases[$key], $method->invoke($factory));
        }
        return $testcases;
    }

    /**
     * @param  mixed  $expected
     */
    public function expectExceptionFromArgument($expected)
    {
        if ($expected instanceof Exception) {
            $this->expectException(get_class($expected));
        }
    }

    /**
     * @return  DriversFactory
     */
    protected function getDriversFactory()
    {
        return new DriversFactory;
    }
}
