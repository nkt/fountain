<?php

namespace Fountain\Schema;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class Index extends Schema
{
    /**
     * @var string[]
     */
    private $columns = [];
    /**
     * @var string
     */
    private $type = 'index';

    /**
     * @param string[] $columns
     * @param string   $name
     * @param int      $type
     */
    public function __construct(array $columns, $name = null, $type = null)
    {
        if (empty($columns)) {
            throw new Exception('Index should contains at least one column');
        }
        foreach ($columns as $column) {
            $this->addColumn($column);
        }
        if ($type !== null) {
            $this->setType($type);
        }
        if ($name === null) {
            $name = $this->generateIdentifier($columns, $this->getType());
        }
        $this->setName($name);
    }

    /**
     * {@inheritdoc}
     */
    static public function fromArray(array $schema)
    {
        $schema = array_replace([
            'name'    => null,
            'columns' => [],
            'type'    => null
        ], $schema);

        return new Index($schema['columns'], $schema['name'], $schema['type']);
    }

    /**
     * @param string $column
     */
    public function addColumn($column)
    {
        $this->columns[$column] = true;
    }

    /**
     * @return string[]
     */
    public function getColumns()
    {
        return array_keys($this->columns);
    }

    /**
     * @param string $column
     *
     * @return bool
     */
    public function hasColumn($column)
    {
        return isset($this->columns[$column]);
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
