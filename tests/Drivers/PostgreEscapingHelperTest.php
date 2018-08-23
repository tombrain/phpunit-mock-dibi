<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

/**
 * PostgreEscapingHelperTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class PostgreEscapingHelperTest extends Testcase
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
            ["", "''"],
            ["''", "''''''"],  // Each quote doubled + wrapped with quotes.
            ["\\", "'\\\\'"],
            ["3.14", "'3.14'"],
            [chr(0x0).chr(0x0d).chr(0x0a).chr(0x19).chr(0x7f), "'\\000\\015\\012\\031\\177'"],
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
            ["", "''"],
            ["''", "''''''"],  // Each quote doubled + wrapped with quotes.
            ["\\", "'\\'"],
            [3.14, "'3.14'"],
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
            ["''", "''"],      // Does not unqoute.
            ["''''", "''''"],
            ["\\\\", "\\"],
            ["\\\\\\", "\\"],  // Backslash discarded at the end of the string.
            ["3.14", "3.14"],
            ["\\000\\015\\012\\031\\177", chr(0x0).chr(0x0d).chr(0x0a).chr(0x19).chr(0x7f)],
        ];
    }

    /**
     * @return  PostgreEscapingHelper
     */
    private function createObject()
    {
        return new PostgreEscapingHelper;
    }
}
