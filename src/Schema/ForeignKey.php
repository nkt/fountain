<?php

namespace Fountain\Schema;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class ForeignKey extends Schema
{
    /**
     * @var Table
     */
    protected $localTable;
    /**
     * @var Column[]
     */
    protected $localColumns;
    /**
     * @var Table
     */
    protected $foreignTable;
    /**
     * @var Column[]
     */
    protected $foreignColumns;

    /**
     * @param Column[] $localColumns
     * @param Column[] $foreignColumns
     * @param array    $options
     */
    public function __construct(array $localColumns, array $foreignColumns, array $options = null)
    {
        if ($options === null) {
            $this->setOptions($options);
        }
    }

    /**
     * @return Table
     */
    public function getForeignTable()
    {
        return $this->foreignTable;
    }

    /**
     * @return Table
     */
    public function getLocalTable()
    {
        return $this->localTable;
    }
}
