<?php

namespace Fountain\Schema;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class Table extends Schema
{
    /**
     * @var Column[]
     */
    protected $columns = [];
    /**
     * @var Index[]
     */
    protected $indexes = [];
    /**
     * @var ForeignKey[]
     */
    protected $foreignKeys = [];

    /**
     * @param string   $name
     * @param Column[] $columns
     * @param Index[]  $indexes
     * @param array    $options
     * @param string   $charset
     */
    public function __construct($name, array $columns = [], array $indexes = [], array $options = [], $charset = null)
    {
        $this->setName($name);
        foreach ($columns as $column) {
            $this->addColumn($column);
        }
        foreach ($indexes as $index) {
            $this->addIndex($index);
        }
        $this->setOptions($options);
        if ($charset !== null) {
            $this->setCharset($charset);
        }
    }

    public static function fromArray(array $schema)
    {
        parent::fromArray($schema);
        $schema = array_replace([
            'columns' => [],
            'indexes' => [],
            'options' => [],
            'charset' => null
        ], $schema);

        $table = new Table($schema['name'], [], [], $schema['options'], $schema['charset']);

        foreach ($schema['columns'] as $key => $column) {
            if (is_string($key)) {
                if (is_string($column)) {
                    $column = [
                        'name' => $key,
                        'type' => $column
                    ];
                } elseif (!isset($column['name'])) {
                    $column['name'] = $key;
                }
            }
            $table->addColumn(Column::fromArray($column));
        }
        foreach ($schema['indexes'] as $key => $index) {
            if (is_string($index) || !isset($index['columns'])) {
                $index = ['columns' => $index];
            }
            $index['columns'] = (array)$index['columns'];
            if (is_string($key) && !isset($index['name'])) {
                $index['name'] = $key;
            }
            $table->addIndex(Index::fromArray($index));
        }

        return $table;
    }

    public function addColumn(Column $column)
    {
        $this->columns[$column->getName()] = $column;
    }

    public function removeColumn($name)
    {
        $this->assertHasColumn($name);
        unset($this->columns[$name]);
    }

    public function hasColumn($name)
    {
        return isset($this->columns[$name]);
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function addIndex(Index $index)
    {
        foreach ($index->getColumns() as $column) {
            $this->assertHasColumn($column);
        }

        $this->indexes[$index->getName()] = $index;
    }

    public function removeIndex($name)
    {
        $this->assertHasIndex($name);
        unset($this->indexes[$name]);
    }

    public function getIndexes()
    {
        return $this->indexes;
    }

    protected function assertHasIndex($name)
    {
        if (!isset($this->indexes[$name])) {
            throw new Exception(sprintf('Table "%s" not contains index names "%s"', $this->getName(), $name));
        }
    }

    protected function assertHasColumn($name)
    {
        if (!isset($this->columns[$name])) {
            throw new Exception(sprintf('Table "%s" not contains column names "%s"', $this->getName(), $name));
        }
    }
}
