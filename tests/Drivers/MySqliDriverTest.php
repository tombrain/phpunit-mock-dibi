<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotImplementedException;

/**
 * MySqliDriverTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MySqliDriverTest extends Testcase
{
    /**
     * @dataProvider  provideBegin
     */
    public function testBegin($savepoint, $expected)
    {
        $object = $this->createObject();
        $object->begin($savepoint);
        $this->assertExecutedQuery($object, $expected);
    }

    public function provideBegin()
    {
        return [
            [NULL, 'START TRANSACTION'],
            ['s1', 'SAVEPOINT s1'],
        ];
    }

    /**
     * @dataProvider  provideCommit
     */
    public function testCommit($savepoint, $expected)
    {
        $object = $this->createObject();
        $object->commit($savepoint);
        $this->assertExecutedQuery($object, $expected);
    }

    public function provideCommit()
    {
        return [
            [NULL, 'COMMIT'],
            ['s1', 'RELEASE SAVEPOINT s1'],
        ];
    }

    /**
     * @dataProvider  provideRollback
     */
    public function testRollback($savepoint, $expected)
    {
        $object = $this->createObject();
        $object->rollback($savepoint);
        $this->assertExecutedQuery($object, $expected);
    }

    public function provideRollback()
    {
        return [
            [NULL, 'ROLLBACK'],
            ['s1', 'ROLLBACK TO SAVEPOINT s1'],
        ];
    }

    /**
     * @dataProvider  provideEscapeBinary
     */
    public function testEscapeBinary($value, $expected)
    {
        $object = $this->createObject();
        $actual = $object->escapeBinary($value);
        $this->assertSame($expected, $actual);
    }

    public function provideEscapeBinary()
    {
        return [
            ["value", "_binary'value'"],
        ];
    }

    /**
     * @dataProvider  provideEscapeText
     */
    public function testEscapeText($value, $expected)
    {
        $object = $this->createObject();
        $actual = $object->escapeText($value);
        $this->assertSame($expected, $actual);
    }

    public function provideEscapeText()
    {
        return [
            ["value", "'value'"],
        ];
    }

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
     * @dataProvider  provideReturnNullMethods
     */
    public function testReturnNullMethods($methodName, $arguments)
    {
        $object = $this->createObject();
        $actual = call_user_func_array([$object, $methodName], $arguments);
        $this->assertNull($actual);
    }

    public function provideReturnNullMethods()
    {
        return [
            ['getResource', []],
        ];
    }

    /**
     * @return  MySqliDriver
     */
    private function createObject()
    {
        return $this->getDriversFactory()
            ->createMySqliDriver();
    }
}
