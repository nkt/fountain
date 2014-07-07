<?php

namespace Fountain;

use Fountain\Mapping\EntityMetadata;
use Traversable;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class EntityRepository implements \IteratorAggregate
{
    /**
     * @var UnitOfWork
     */
    protected $unitOfWork;
    /**
     * @var EntityMetadata
     */
    protected $metadata;
    /**
     * @var string
     */
    protected $className;

    public function __construct(EntityManager $em, EntityMetadata $metadata)
    {
        $this->em = $em;
        $this->metadata = $metadata;
    }

    public function createQueryBuilder()
    {
    }

    /**
     * @return Collection
     */
    public function findAll()
    {
    }

    /**
     * @param mixed $id
     *
     * @return object
     */
    public function find($id)
    {
        return $this->unitOfWork->find($this->className, $id);
    }

    /**
     * @return Traversable
     */
    public function getIterator()
    {
        return $this->findAll();
    }
}
