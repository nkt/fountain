<?php

namespace Fountain\Schema;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class Table
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var Column[]
     */
    protected $columns;
    /**
     * @var array
     */
    protected $options = [];
}
