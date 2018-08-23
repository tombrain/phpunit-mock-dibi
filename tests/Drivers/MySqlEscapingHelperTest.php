<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

/**
 * MySqlEscapingHelperTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MySqlEscapingHelperTest extends Testcase
{
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
            [NULL, "_binary''"],
            [TRUE, "_binary'1'"],
            [FALSE, "_binary''"],
            [0, "_binary'0'"],
            [1, "_binary'1'"],
            [3.14, "_binary'3.14'"],
            ['foo', "_binary'foo'"],
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
            [NULL, "''"],
            [TRUE, "'1'"],
            [FALSE, "''"],
            [0, "'0'"],
            [1, "'1'"],
            [3.14, "'3.14'"],
            ['foo', "'foo'"],
            ["\\\x00\n\r'\"\x1a", "'\\\\\\0\\n\\r\'\\\"\\Z'"],
        ];
    }

    /**
     * @return  MySqlEscapingHelper
     */
    private function createObject()
    {
        return new MySqlEscapingHelper;
    }
}
