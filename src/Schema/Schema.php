<?php

namespace Fountain\Schema;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
abstract class Schema implements \Serializable
{
    /**
     * @var string
     */
    protected $name;
    private $data;

    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }
}
