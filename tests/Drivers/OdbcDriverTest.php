<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotImplementedException;

/**
 * OdbcDriverTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class OdbcDriverTest extends Testcase
{
    /**
     * @dataProvider  provideTransaction
     */
    public function testBegin($savepoint)
    {
        $object = $this->createObject();
        $object->begin($savepoint);
        $this->assertTrue($object->inTransaction());
    }

    /**
     * @dataProvider  provideTransaction
     */
    public function testCommit($savepoint)
    {
        $object = $this->createObject();
        $object->commit($savepoint);
        $this->assertFalse($object->inTransaction());
    }

    /**
     * @dataProvider  provideTransaction
     */
    public function testRollback($savepoint)
    {
        $object = $this->createObject();
        $object->rollback($savepoint);
        $this->assertFalse($object->inTransaction());
    }

    public function provideTransaction()
    {
        return [
            [NULL],
            ['savepoint'],
        ];
    }

    /**
     * @dataProvider  provideInTransaction
     */
    public function testInTransaction($expected)
    {
        $object = $this->createObject();
        $this->getReflectionProperty($object, 'inTransaction')
            ->setValue($object, $expected);
        $actual = $object->inTransaction();
        $this->assertSame($expected, $actual);
    }

    public function provideInTransaction()
    {
        return [
            [TRUE],
            [FALSE],
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
            ['getTables', []],
            ['getColumns', ['t1']],
        ];
    }

    /**
     * @return  OdbcDriver
     */
    private function createObject()
    {
        return $this->getDriversFactory()
            ->createOdbcDriver();
    }
}
