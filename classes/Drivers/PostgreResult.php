<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\Drivers;

/**
 * PostgreResult
 * 
 * @author   czukowski
 * @license  MIT License
 */
class PostgreResult extends Drivers\PostgreResult
{
    use MockQueryResultDriverTrait;
}
