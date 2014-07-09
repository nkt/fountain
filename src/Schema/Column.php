<?php

namespace Fountain\Schema;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class Column extends Schema
{
    /**
     * @var string
     */
    protected $type = 'string';
    /**
     * @var int
     */
    protected $length;
    /**
     * @var int
     */
    protected $precision = 10;
    /**
     * @var bool
     */
    protected $unsigned = false;
    /**
     * @var bool
     */
    protected $nullable = false;
    /**
     * @var mixed
     */
    protected $default;
    /**
     * @var string
     */
    protected $comment;

    /**
     * @param string $name
     * @param string $type
     * @param int    $length
     * @param bool   $nullable
     * @param bool   $default
     */
    public function __construct($name, $type = null, $length = null, $nullable = null, $default = null)
    {
        $this->setName($name);
        if ($type !== null) {
            $this->setType($type);
        }
        if ($length !== null) {
            $this->setLength($length);
        }
        if ($nullable !== null) {
            $this->setNullable($nullable);
        }
        if ($default !== null) {
            $this->setDefault($default);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $schema)
    {
        parent::fromArray($schema);
        $schema = array_replace([
            'type'      => null,
            'length'    => null,
            'precision' => null,
            'unsigned'  => null,
            'nullable'  => null,
            'default'   => null,
            'comment'   => null,
            'options'   => null
        ], $schema);

        $column = new Column($schema['name'], $schema['type'], $schema['length'], $schema['nullable'], $schema['default']);
        if ($schema['precision'] !== null) {
            $column->setPrecision($schema['precision']);
        }
        if ($schema['unsigned'] !== null) {
            $column->setUnsigned($schema['unsigned']);
        }
        if ($schema['comment'] !== null) {
            $column->setComment($schema['comment']);
        }
        if ($schema['options'] !== null) {
            $column->setOptions($schema['options']);
        }

        return $column;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->length = (int)$length;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param bool $nullable
     */
    public function setNullable($nullable)
    {
        $this->nullable = (bool)$nullable;
    }

    /**
     * @return bool
     */
    public function isNullable()
    {
        return $this->nullable;
    }

    /**
     * @param int $precision
     */
    public function setPrecision($precision)
    {
        $this->precision = (int)$precision;
    }

    /**
     * @return int
     */
    public function getPrecision()
    {
        return $this->precision;
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
     * @param bool $unsigned
     */
    public function setUnsigned($unsigned)
    {
        $this->unsigned = (bool)$unsigned;
    }

    /**
     * @return bool
     */
    public function isUnsigned()
    {
        return $this->unsigned;
    }
}
