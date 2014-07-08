<?php

namespace Fountain\Schema;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class Index extends Schema
{
    /**
     * @var Column[]
     */
    private $columns = [];
    /**
     * @var string
     */
    private $type = 'index';

    /**
     * @param Column[] $columns
     * @param string   $name
     * @param int      $type
     */
    public function __construct(array $columns, $name = null, $type = null)
    {
        foreach ($columns as $column) {
            $this->addColumn($column);
        }
        if ($name === null) {
            $name = $this->generateIdentifier($columns);
        }
        $this->setName($name);
        if ($type !== null) {
            $this->setType($type);
        }
    }

    /**
     * @param Column $column
     */
    public function addColumn(Column $column)
    {
        $this->columns[$column->getName()] = $column;
    }

    /**
     * @return Column[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isIndex()
    {
        return $this->type === 'index';
    }

    /**
     * @return bool
     */
    public function isPrimary()
    {
        return $this->type === 'primary';
    }

    /**
     * @return bool
     */
    public function isUnique()
    {
        return $this->type === 'unique';
    }
}
