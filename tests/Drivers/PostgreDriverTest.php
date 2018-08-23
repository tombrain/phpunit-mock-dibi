<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotImplementedException,
    ReflectionProperty;

/**
 * PostgreDriverTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class PostgreDriverTest extends Testcase
{
    /**
     * @dataProvider  provideGetInsertId
     */
    public function testGetInsertId($lastInsertId, $sequence, $expectedInsertId, $expectedQuery)
    {
        $object = $this->createObject();
        $object->setInsertId($lastInsertId);
        $actual = $object->getInsertId($sequence);
        $this->assertSame($expectedInsertId, $actual);
        $this->assertExecutedQuery($object, $expectedQuery);
    }

    public function provideGetInsertId()
    {
        return [
            [NULL, NULL, FALSE, "SELECT LASTVAL()"],
            [0, NULL, FALSE, "SELECT LASTVAL()"],
            [1, NULL, 1, "SELECT LASTVAL()"],
            [NULL, 's1', FALSE, "SELECT CURRVAL('s1')"],
            [0, 's1', FALSE, "SELECT CURRVAL('s1')"],
            [1, 's1', 1, "SELECT CURRVAL('s1')"],
        ];
    }

    /**
     * @dataProvider  provideBegin
     */
    public function testBegin($savepoint, $expected)
    {
        $object = $this->createObject();
        $object->begin($savepoint);
        $this->assertTrue($object->inTransaction());
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
        $this->assertFalse($object->inTransaction());
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
        $this->assertFalse($object->inTransaction());
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
     * @dataProvider  provideInTransaction
     */
    public function testInTransaction($expected)
    {
        $object = $this->createObject();
        $this->getObjectInTransactionProperty($object)
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
            ["value", "'value'"],
        ];
    }

    /**
     * @dataProvider  provideEscapeLike
     */
    public function testEscapeLike($value, $pos, $expected)
    {
        $object = $this->createObject();
        $actual = $object->escapeLike($value, $pos);
        $this->assertSame($expected, $actual);
    }

    public function provideEscapeLike()
    {
        return [
            ["va_\\%", -1, "'%va\_\\\\\%'"],
            ["va_\\%", 0, "'%va\_\\\\\%%'"],
            ["va_\\%", 1, "'va\_\\\\\%%'"],
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
     * @dataProvider  provideUnescapeBinary
     */
    public function testUnescapeBinary($value, $expected)
    {
        $object = $this->createObject();
        $actual = $object->unescapeBinary($value);
        $this->assertSame($expected, $actual);
    }

    public function provideUnescapeBinary()
    {
        return [
            ["value", "value"],
        ];
    }

    /**
     * @dataProvider  provideNotImplementedMethods
     */
    public function testNotImplementedMethods($method, $args)
    {
        $object = $this->createObject();
        $this->expectException(NotImplementedException::class);
        call_user_func_array([$object, $method], $args);
    }

    public function provideNotImplementedMethods()
    {
        return [
            ['ping', []],
            ['getTables', []],
            ['getColumns', ['t1']],
        ];
    }

    /**
     * @return  PostgreDriver
     */
    private function createObject()
    {
        return new PostgreDriver;
    }

    /**
     * @param   PostgreDriver  $object
     * @return  ReflectionProperty
     */
    private function getObjectInTransactionProperty(PostgreDriver $object)
    {
        $inTransaction = new ReflectionProperty($object, 'inTransaction');
        $inTransaction->setAccessible(TRUE);
        return $inTransaction;
    }
}
