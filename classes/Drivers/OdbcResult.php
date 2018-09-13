<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\Drivers;

/**
 * OdbcResult
 * 
 * @author   czukowski
 * @license  MIT License
 */
class OdbcResult extends Drivers\OdbcResult
{
    use MockQueryResultDriverTrait;
}
