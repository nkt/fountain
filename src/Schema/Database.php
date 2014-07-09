<?php

namespace Fountain\Schema;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class Database extends Schema
{
    /**
     * @var Table[]
     */
    protected $tables = [];

    /**
     * @param string  $name
     * @param Table[] $tables
     * @param string  $charset
     */
    public function __construct($name, array $tables = [], $charset = null)
    {
        $this->setName($name);
        foreach ($tables as $table) {
            $this->addTable($table);
        }
        if ($charset !== null) {
            $this->setCharset($charset);
        }
    }

    /**
     * @param Table $table
     */
    public function addTable(Table $table)
    {
        $this->tables[$table->getName()] = $table;
    }

    /**
     * @param Table $table
     */
    public function removeTable(Table $table)
    {
        unset($this->tables[$table->getName()]);
    }

    /**
     * @param string $name
     *
     * @return Table
     */
    public function getTable($name)
    {
        if (!isset($this->tables[$name])) {
            throw new Exception('There is no table named ' . $name);
        }

        return $this->tables[$name];
    }

    /**
     * @return Table[]
     */
    public function getTables()
    {
        return $this->tables;
    }
}
