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
     * @param   string  $value
     * @return  string
     */
    public static function escapeBinary($value)
    {
        return "_binary'".self::mySqlRealEscapeString($value)."'";
    }

    /**
     * @param   string  $value
     * @return  string
     */
    public static function escapeText($value)
    {
        return "'".self::mySqlRealEscapeString($value)."'";
    }

    /**
     * Cheap and dirty replacement for `mysql_real_escape_string`
     * 
     * @see  http://stackoverflow.com/a/1162502/1570537
     */
    private static function mySqlRealEscapeString($value)
    {
        $search = ["\\", "\x00", "\n", "\r", "'", '"', "\x1a"];
        $replace = ["\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z"];
        return str_replace($search, $replace, $value);
    }
}
