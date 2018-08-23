<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

/**
 * PostgreEscapingHelper
 * 
 * Based on PostgreSQL code, `fe-exec.c`.
 * 
 * @link  https://git.postgresql.org/gitweb/?p=postgresql.git;a=blob;f=src/interfaces/libpq/fe-exec.c
 * 
 * Portions Copyright (c) 1996-2018, PostgreSQL Global Development Group
 * Portions Copyright (c) 1994, Regents of the University of California
 * 
 * @author   czukowski
 * @license  MIT License
 */
class PostgreEscapingHelper
{
    /**
     * A replacement for `pg_escape_bytea`, adapted version of libpq code.
     * 
     * In escape mode, the following transformations are applied:
     * 
     *  - '\0' == ASCII  0 == \000
     *  - '\'' == ASCII 39 == ''
     *  - '\\' == ASCII 92 == \\
     *  - anything < 0x20, or > 0x7e ---> \ooo (where ooo is an octal expression)
     * 
     * @param   string  $value
     * @return  string
     */
    public static function escapeBinary($value)
    {
        $result = "'";
        for ($i = 0; $i < strlen($value); $i++) {
            $dec = ord($value[$i]);
            if ($dec === 39) {
                $result .= "''";
            }
            elseif ($dec === 92) {
                $result .= '\\\\';
            }
            elseif ($dec < 0x20 || $dec > 0x7e) {
                $result .= '\\'.str_pad(decoct($dec), 3, '0', STR_PAD_LEFT);
            }
            else {
                $result .= $value[$i];
            }
        }
        $result .= "'";
        return $result;
    }

    /**
     * A cheap and dirty replacement for `pg_escape_string`.
     * 
     * @param   string  $value
     * @return  string
     */
    public static function escapeText($value)
    {
        return "'".str_replace("'", "''", $value)."'";
    }

    /**
     * A replacement for `pg_unescape_bytea`, adapted version of libpq code.
     * 
     * The following transformations are made:
     * 
     *  - \\   == ASCII 92 == \
     *  - \ooo == a byte whose value = ooo (ooo is an octal number)
     *  - \x   == x (x is any character not matched by the above transformations)
     * 
     * @param   string  $value
     * @return  string
     */
    public static function unescapeBinary($value)
    {
        $result = '';
        $length = strlen($value);
        $i = 0;
        while ($i < $length) {
            if ($value[$i] === '\\') {
                $i++;
                if (substr($value, $i, 1) === '\\') {
                    $result .= $value[$i++];
                }
                elseif (self::isOctValue(substr($value, $i, 3))) {
                    $result .= chr(octdec(substr($value, $i, 3)));
                    $i += 3;
                }
                // Note: if we see '\' followed by something that isn't a
                // recognized escape sequence, we loop around having done
                // nothing except advance i.  Therefore the something will
                // be emitted as ordinary data on the next cycle. Corner
                // case: '\' at end of string will just be discarded.
            }
            else {
                $result .= $value[$i++];
            }
        }
        return $result;
    }

    /**
     * @param   string  $value
     * @return  boolean
     */
    private static function isOctValue($value)
    {
        return strlen($value) === 3
            && $value[0] >= '0' && $value[0] <= '3'
            && $value[1] >= '0' && $value[1] <= '7'
            && $value[2] >= '0' && $value[2] <= '7';
    }
}
