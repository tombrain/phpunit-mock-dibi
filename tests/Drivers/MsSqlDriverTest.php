<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

/**
 * MsSqlDriverTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MsSqlDriverTest extends Testcase
{
    /**
     * @dataProvider  provideGetInsertId
     */
    public function testGetInsertId($lastInsertId, $sequence, $expected)
    {
        $object = $this->createObject();
        $object->setInsertId($lastInsertId);
        $actual = $object->getInsertId($sequence);
        $this->assertSame($expected, $actual);
        $queries = $object->getExecutedQueries();
        $this->assertCount(1, $queries);
        $this->assertSame('SELECT @@IDENTITY', reset($queries));
    }

    public function provideGetInsertId()
    {
        return [
            [NULL, NULL, FALSE],
            [0, NULL, FALSE],
            [1, NULL, 1],
            [NULL, 's1', FALSE],
            [0, 's1', FALSE],
            [1, 's1', 1],
        ];
    }

    /**
     * @return  MsSqlDriver
     */
    private function createObject()
    {
        return $this->getDriversFactory()
            ->createMsSqlDriver();
    }
}
