<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

/**
 * MySqlEscapingHelper
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MySqlEscapingHelper
{
    /**
     * @param   mixed  $value
     * @return  string
     */
    public static function escapeBinary($value): string
    {
        return "_binary'".self::mySqlRealEscapeString($value)."'";
    }

    /**
     * @param   mixed  $value
     * @return  string
     */
    public static function escapeText($value): string
    {
        return "'".self::mySqlRealEscapeString($value)."'";
    }

    /**
     * Cheap and dirty replacement for `mysql_real_escape_string`
     * 
     * @see  http://stackoverflow.com/a/1162502/1570537
     */
    private static function mySqlRealEscapeString($value): string
    {
        $search = ["\\", "\x00", "\n", "\r", "'", '"', "\x1a"];
        $replace = ["\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z"];
        return str_replace($search, $replace, $value);
    }
}
