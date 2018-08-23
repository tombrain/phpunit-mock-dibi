<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Cz\PHPUnit\MockDB,
    Cz\PHPUnit\SQL,
    Dibi\Drivers;

/**
 * MySqlDriver
 * 
 * @author   czukowski
 * @license  MIT License
 */
class MySqlDriver extends Drivers\MySqlDriver implements
    MockDB\DatabaseDriverInterface,
    SQL\DatabaseDriverInterface
{
    use MockQueryConnectionTrait;
    use MockQueryDriverTrait;
    use MockQueryResultDriverTrait;
    use MySqlDriverTrait;
}
