<?php

namespace Fountain;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class UnitOfWork
{
    const STATE_NEW = 1;
    const STATE_UPDATED = 2;
    const STATE_REMOVED = 3;
    /**
     * @var \SplObjectStorage
     */
    protected $identityMap;

    public function __construct()
    {
        $this->identityMap = new \SplObjectStorage();
    }

    /**
     * @param string $name
     * @param mixed  $id
     *
     * @return object
     */
    public function find($name, $id)
    {
    }

    public function persist($object)
    {
    }

    public function remove($object)
    {
    }

    public function merge($object)
    {
    }

    public function refresh($object)
    {
    }

    public function flush()
    {
    }
}
