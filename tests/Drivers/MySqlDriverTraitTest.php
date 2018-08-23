<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotImplementedException,
    PHPUnit_Framework_MockObject_MockObject as Mock;

/**
 * MySqlDriverTraitTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MySqlDriverTraitTest extends Testcase
{
    /**
     * @dataProvider  provideBegin
     */
    public function testBegin($savepoint, $expected)
    {
        $object = $this->createObject();
        $this->expectAddExecutedQuery($object, $expected);
        $object->begin($savepoint);
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
        $this->expectAddExecutedQuery($object, $expected);
        $object->commit($savepoint);
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
        $this->expectAddExecutedQuery($object, $expected);
        $object->rollback($savepoint);
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
     * @return  MySqlDriverTrait
     */
    private function createObject()
    {
        return $this->getMockForTrait(MySqlDriverTrait::class);
    }

    /**
     * @param  Mock    $object
     * @param  string  $sql
     */
    private function expectAddExecutedQuery(Mock $object, $sql)
    {
        $object->expects($this->once())
            ->method('addExecutedQuery')
            ->with($sql);
    }
}
