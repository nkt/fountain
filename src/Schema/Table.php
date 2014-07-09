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
     * @var array
     */
    protected $options = [];

    /**
     * @param string       $name
     * @param Column[]     $columns
     * @param Index[]      $indexes
     * @param ForeignKey[] $foreignKeys
     * @param array        $options
     * @param string       $charset
     */
    public function __construct($name, array $columns = [], array $indexes = [], array $foreignKeys = [], array $options = [], $charset = null)
    {
        $this->setName($name);
        foreach ($columns as $column) {
            $this->addColumn($column);
        }
        foreach ($indexes as $index) {
            $this->addIndex($index);
        }
        foreach ($foreignKeys as $key) {
            $this->addForeignKey($key);
        }
        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }
        if ($charset !== null) {
            $this->setCharset($charset);
        }
    }

    public static function fromArray(array $schema)
    {
        parent::fromArray($schema);
        $schema = array_replace([
            'columns'     => [],
            'indexes'     => [],
            'foreignKeys' => [],
            'options'     => [],
            'charset'     => null
        ], $schema);

        $table = new Table($schema['name'], [], [], [], $schema['options'], $schema['charset']);

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
            if (is_string($index)) {
                $index = ['columns' => [$index]];
            } elseif (!isset($index['columns'])) {
                $index = ['columns' => $index];
            }
            if (is_string($key) && !isset($index['name'])) {
                $index['name'] = $key;
            }
            foreach ($index['columns'] as $column) {
                if (!$table->hasColumn($column)) {
                    throw new Exception('Table schema not describe column named ' . $column);
                }
            }

            $table->addIndex(Index::fromArray($index));
        }

        return $table;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function addColumn(Column $column)
    {
        $this->columns[$column->getName()] = $column;
    }

    public function hasColumn($name)
    {
        return isset($this->columns[$name]);
    }

    public function removeColumn(Column $column)
    {
        unset($this->columns[$column->getName()]);
    }

    public function getIndexes()
    {
        return $this->indexes;
    }

    public function addIndex(Index $index)
    {
        $this->indexes[$index->getName()] = $index;
    }

    public function removeIndex(Index $index)
    {
        unset($this->indexes[$index->getName()]);
    }

    public function getForeignKeys()
    {
        return $this->foreignKeys;
    }

    public function addForeignKey(ForeignKey $key)
    {
        $this->foreignKeys[$key->getName()] = $key;
    }

    public function removeForeignKey(ForeignKey $index)
    {
        unset($this->foreignKeys[$index->getName()]);
    }

    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
