<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use DateTime,
    Dibi\DateTime as DibiDateTime,
    Dibi\NotImplementedException,
    Dibi\NotSupportedException;

/**
 * Sqlite3DriverTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class Sqlite3DriverTest extends Testcase
{
    /**
     * @dataProvider  provideConnect
     */
    public function testConnect($config, $expectedFmtDate, $expectedFmtDateTime)
    {
        $object = $this->createObject();
        $object->connect($config);
        $actualFmtDate = $this->getObjectAttribute($object, 'fmtDate');
        $this->assertSame($expectedFmtDate, $actualFmtDate);
        $actualFmtDateTime = $this->getObjectAttribute($object, 'fmtDateTime');
        $this->assertSame($expectedFmtDateTime, $actualFmtDateTime);
    }

    public function provideConnect()
    {
        return [
            [
                [],
                'U',
                'U',
            ],
            [
                ['formatDate' => 'Y-m-d', 'formatDateTime' => 'Y-m-d H:i:s'],
                'Y-m-d',
                'Y-m-d H:i:s',
            ],
        ];
    }

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
            [NULL, 'BEGIN'],
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
     * @dataProvider  provideEscapeDate
     */
    public function testEscapeDate($value, $expected)
    {
        $object = $this->createObject();
        $config = ['formatDate' => 'Y-m-d'];
        $object->connect($config);
        $actual = $object->escapeDate($value);
        $this->assertSame($expected, $actual);
    }

    public function provideEscapeDate()
    {
        return [
            [1525932234, '2018-05-10'],
            ['2018-05-10 08:18:53', '2018-05-10'],
            [new DateTime('2018-05-10 00:00:00'), '2018-05-10'],
            [new DibiDateTime('2018-05-10 23:59:59'), '2018-05-10'],
        ];
    }

    /**
     * @dataProvider  provideEscapeDateTime
     */
    public function testEscapeDateTime($value, $expected)
    {
        $object = $this->createObject();
        $config = ['formatDateTime' => 'Y-m-d H:i:s'];
        $object->connect($config);
        $actual = $object->escapeDateTime($value);
        $this->assertSame($expected, $actual);
    }

    public function provideEscapeDateTime()
    {
        return [
            [1525932234, '2018-05-10 06:03:54'],
            ['2018-05-10 08:18:53', '2018-05-10 08:18:53'],
            [new DateTime('2018-05-10 00:00:00'), '2018-05-10 00:00:00'],
            [new DibiDateTime('2018-05-10 23:59:59'), '2018-05-10 23:59:59'],
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
            ["va_'\\%e", -1, "'%va\_''\\\\\%e' ESCAPE '\'"],
            ["va_'\\%e", 0, "'%va\_''\\\\\%e%' ESCAPE '\'"],
            ["va_'\\%e", 1, "'va\_''\\\\\%e%' ESCAPE '\'"],
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
            ["va'ue", "'va''ue'"],
        ];
    }

    /**
     * @dataProvider  provideUnsupportedMethods
     */
    public function testUnsupportedMethods($method, $arguments)
    {
        $object = $this->createObject();
        $this->expectException(NotSupportedException::class);
        call_user_func_array([$object, $method], $arguments);
    }

    public function provideUnsupportedMethods()
    {
        return [
            ['getRowCount', []],
            ['seek', [0]],
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
            ['registerFunction', ['', function () {}]],
            ['registerAggregateFunction', ['', function () {}, function () {}]],
        ];
    }

    /**
     * @return  Sqlite3Driver
     */
    private function createObject()
    {
        return new Sqlite3Driver;
    }
}
