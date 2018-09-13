<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotSupportedException;

/**
 * FirebirdDriverTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class FirebirdDriverTest extends Testcase
{
    /**
     * @dataProvider  provideTransaction
     */
    public function testBegin($savepoint, $expected)
    {
        $object = $this->createObject();
        $this->expectExceptionFromArgument($expected);
        $actual = $object->begin($savepoint);
        $this->assertSame($expected, $actual);
        $this->assertTrue($object->inTransaction());
    }

    /**
     * @dataProvider  provideTransaction
     */
    public function testCommit($savepoint, $expected)
    {
        $object = $this->createObject();
        $this->expectExceptionFromArgument($expected);
        $actual = $object->commit($savepoint);
        $this->assertSame($expected, $actual);
        $this->assertFalse($object->inTransaction());
    }

    /**
     * @dataProvider  provideTransaction
     */
    public function testRollback($savepoint, $expected)
    {
        $object = $this->createObject();
        $this->expectExceptionFromArgument($expected);
        $actual = $object->rollback($savepoint);
        $this->assertSame($expected, $actual);
        $this->assertFalse($object->inTransaction());
    }

    public function provideTransaction()
    {
        return [
            [NULL, NULL],
            ['savepoint', new NotSupportedException],
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
     * @dataProvider  provideCreateResultDriver
     */
    public function testCreateResultDriver($resultSet)
    {
        $object = $this->createObject();
        $actual = $object->createResultDriver($resultSet);
        $this->assertInstanceOf(FirebirdResult::class, $actual);
    }

    public function provideCreateResultDriver()
    {
        return [
            [NULL],
            [[]],
            [[['id' => 1], ['id' => 2]]],
        ];
    }

    /**
     * @return  FirebirdDriver
     */
    private function createObject()
    {
        return $this->getDriversFactory()
            ->createFirebirdDriver();
    }
}
