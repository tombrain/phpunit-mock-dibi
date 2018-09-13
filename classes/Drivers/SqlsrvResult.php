<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\Drivers;

/**
 * SqlsrvResult
 * 
 * @author   czukowski
 * @license  MIT License
 */
class SqlsrvResult extends Drivers\SqlsrvResult
{
    use MockQueryResultDriverTrait;
}
