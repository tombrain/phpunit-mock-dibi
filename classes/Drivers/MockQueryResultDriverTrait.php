<?php
namespace Cz\PHPUnit\MockDibi\Drivers;

use Dibi\NotImplementedException,
    Dibi\ResultDriver;

/**
 * MockQueryResultDriverTrait
 * 
 * Mock implementation of `Dibi\ResultDriver` interface. Mock drivers may use it as a base while
 * extending the actual driver class and override some of the methods where needed.
 * 
 * @author   czukowski
 * @license  MIT License
 */
trait MockQueryResultDriverTrait
{
    /**
     * @var  mixed
     */
    private $cursor;
    /**
     * @var  mixed
     */
    private $resultSet;

    /**
     * Implements abstract function from `MockQueryDriverTrait`.
     * 
     * @param   mixed  $resultSet
     * @return  ResultDriver
     */
    public function createResultSet($resultSet)
    {
        $res = clone $this;
        $res->resultSet = $resultSet;
        $res->cursor = NULL;
        return $res;
    }

    /**
     * @return  integer
     */
    public function getRowCount()
    {
        return $this->resultSet !== NULL
            ? count($this->resultSet)
            : 0;
    }

    /**
     * @param   integer  $row
     * @return  boolean
     */
    public function seek($row)
    {
        if (isset($this->resultSet[$row])) {
            $this->cursor = $row;
            return TRUE;
        }
        $this->cursor = NULL;
        return FALSE;
    }

    /**
     * @param   bool  $assoc
     * @return  array|FALSE
     */
    public function fetch($assoc)
    {
        if ($this->cursor === NULL) {
            $this->cursor = 0;
        }
        if (isset($this->resultSet[$this->cursor])) {
            $row = $this->resultSet[$this->cursor];
            $this->cursor++;
            return $assoc ? $row : array_values($row);
        }
        return FALSE;
    }

    /**
     * @return  void
     */
    public function free()
    {
        $this->cursor = NULL;
        $this->resultSet = NULL;
    }

    /**
     * @throws  NotImplementedException
     */
    public function getResultColumns()
    {
        throw new NotImplementedException('Native data types cannot be determined for mock DB connection');
    }

    /**
     * @return  mixed
     */
    public function getResultResource()
    {
        return $this->resultSet;
    }

    /**
     * @param  mixed  $resultSet
     */
    public function setResultResource($resultSet)
    {
        $this->resultSet = $resultSet;
    }

    /**
     * @return  integer|NULL
     */
    public function getCursor()
    {
        return $this->cursor;
    }

    /**
     * @param  mixed  $value
     */
    public function setCursor($value)
    {
        $this->cursor = $value;
    }

    /**
     * @param   string  $value
     * @return  string
     */
    abstract public function unescapeBinary($value);
}
