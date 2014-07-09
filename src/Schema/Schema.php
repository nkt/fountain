<?php

namespace Fountain\Schema;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
abstract class Schema
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $charset = 'UTF-8';
    /**
     * @var array
     */
    protected $options = [];

    public static function fromArray(array $schema)
    {
        if (!isset($schema['name'])) {
            throw new Exception('Schema requires name');
        }
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    protected function generateIdentifier(array $columns, $prefix = null, $length = 30)
    {
        if ($prefix != null) {
            array_unshift($columns, $prefix);
        }

        return substr(join('_', $columns), 0, $length);
    }
}
