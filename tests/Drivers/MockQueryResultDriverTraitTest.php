<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use ArrayObject;

/**
 * MockQueryResultDriverTraitTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MockQueryResultDriverTraitTest extends Testcase
{
    /**
     * @dataProvider  provideGetRowCount
     */
    public function testGetRowCount($resultSet, $expected)
    {
        $object = $this->createObject($resultSet);
        $actual = $object->getRowCount();
        $this->assertSame($expected, $actual);
    }

    public function provideGetRowCount()
    {
        return [
            [
                NULL,
                0,
            ],
            [
                [],
                0,
            ],
            [
                [['id' => 1], ['id' => 2]],
                2,
            ],
            [
                new ArrayObject([['id' => 1], ['id' => 2]]),
                2,
            ],
        ];
    }

    /**
     * @dataProvider  provideSeek
     */
    public function testSeek($resultSet, $row, $expected)
    {
        $object = $this->createObject($resultSet);
        $actual = $object->seek($row);
        list ($expectedReturnValue, $expetedCursor) = $expected;
        $this->assertSame($expectedReturnValue, $actual);
        $this->assertSame($expetedCursor, $object->getCursor());
    }

    public function provideSeek()
    {
        $singleItem = [['id' => 1]];
        $countableObject = new ArrayObject([['id' => 1], ['id' => 2]]);
        return [
            [
                NULL,
                0,
                [FALSE, NULL],
            ],
            [
                [],
                0,
                [FALSE, NULL],
            ],
            [
                $singleItem,
                0,
                [TRUE, 0],
            ],
            [
                $singleItem,
                1,
                [FALSE, NULL],
            ],
            [
                $countableObject,
                -1,
                [FALSE, NULL],
            ],
            [
                $countableObject,
                1,
                [TRUE, 1],
            ],
            [
                $countableObject,
                2,
                [FALSE, NULL],
            ],
        ];
    }

    /**
     * @dataProvider  provideFetch
     */
    public function testFetch($resultSet, $cursor, $assoc, $expected)
    {
        $object = $this->createObject($resultSet, $cursor);
        $actual = $object->fetch($assoc);
        list ($expectedReturnValue, $expetedCursor) = $expected;
        $this->assertSame($expectedReturnValue, $actual);
        $this->assertSame($expetedCursor, $object->getCursor());
    }

    public function provideFetch()
    {
        $singleItem = [['id' => 1]];
        $countableObject = new ArrayObject([['id' => 1], ['id' => 2]]);
        return [
            [
                NULL,
                NULL,
                FALSE,
                [FALSE, 0],
            ],
            [
                NULL,
                NULL,
                TRUE,
                [FALSE, 0],
            ],
            [
                [],
                0,
                TRUE,
                [FALSE, 0],
            ],
            [
                $singleItem,
                NULL,
                TRUE,
                [['id' => 1], 1],
            ],
            [
                $singleItem,
                0,
                TRUE,
                [['id' => 1], 1],
            ],
            [
                $singleItem,
                0,
                FALSE,
                [[0 => 1], 1],
            ],
            [
                $singleItem,
                1,
                TRUE,
                [FALSE, 1],
            ],
            [
                $singleItem,
                1,
                FALSE,
                [FALSE, 1],
            ],
            [
                $countableObject,
                -1,
                FALSE,
                [FALSE, -1],
            ],
            [
                $countableObject,
                NULL,
                TRUE,
                [['id' => 1], 1],
            ],
            [
                $countableObject,
                0,
                FALSE,
                [[0 => 1], 1],
            ],
            [
                $countableObject,
                1,
                TRUE,
                [['id' => 2], 2],
            ],
            [
                $countableObject,
                2,
                FALSE,
                [FALSE, 2],
            ],
        ];
    }

    /**
     * @dataProvider  provideFree
     */
    public function testFree($resultSet, $cursor)
    {
        $object = $this->createObject($resultSet, $cursor);
        $object->free();
        $this->assertNull($object->getResultResource());
        $this->assertNull($object->getCursor());
    }

    public function provideFree()
    {
        return [
            [
                NULL,
                NULL,
            ],
            [
                [['id' => 2]],
                1,
            ],
        ];
    }

    /**
     * @param   mixed  $resultSet
     * @param   mixed  $cursor
     * @return  MockQueryResultDriverTrait
     */
    private function createObject($resultSet = NULL, $cursor = NULL)
    {
        $object = $this->getMockForTrait(MockQueryResultDriverTrait::class);
        $object->setResultResource($resultSet);
        $object->setCursor($cursor);
        return $object;
    }
}
