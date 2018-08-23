<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Cz\PHPUnit\MockDB,
    Cz\PHPUnit\SQL,
    Dibi\Drivers;

/**
 * MySqliDriver
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MySqliDriver extends Drivers\MySqliDriver implements
    MockDB\DatabaseDriverInterface,
    SQL\DatabaseDriverInterface
{
    use MockQueryConnectionTrait;
    use MockQueryDriverTrait;
    use MockQueryResultDriverTrait;
    use MySqlDriverTrait;
}
