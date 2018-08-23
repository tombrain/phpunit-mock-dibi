<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Cz\PHPUnit\MockDibi,
    PDO;

/**
 * PdoConnectionDoubleTest
 * 
 * @author   czukowski
 * @license  MIT License
 */
class PdoConnectionDoubleTest extends MockDibi\Testcase
{
    /**
     * @dataProvider  provideGetAttribute
     */
    public function testGetAttribute($driverName, $attribute, $expected)
    {
        $object = $this->createObject($driverName);
        $actual = $object->getAttribute($attribute);
        $this->assertSame($expected, $actual);
    }

    public function provideGetAttribute()
    {
        return [
            ['pgsql', PDO::ATTR_SERVER_VERSION, NULL],
            ['sqlite', PDO::ATTR_DRIVER_NAME, 'sqlite'],
        ];
    }

    /**
     * @dataProvider  provideQuote
     */
    public function testQuote($value, $type, $expected)
    {
        $object = $this->createObject('no-matter');
        $actual = $object->quote($value, $type);
        $this->assertSame($expected, $actual);
    }

    public function provideQuote()
    {
        return [
            [1, NULL, "'1'"],
            [1, PDO::PARAM_STR, "'1'"],
            [1, PDO::PARAM_LOB, "_binary'1'"],
        ];
    }

    /**
     * @param   string  $driverName
     * @return  PdoConnectionDouble
     */
    private function createObject($driverName)
    {
        return new PdoConnectionDouble($driverName);
    }
}
