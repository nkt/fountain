<?php

namespace Fountain;

use Fountain\Connection\Connection;
use Fountain\Mapping\EntityMetadata;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class EntityManager
{
    const VERSION = '0.1.0';
    /**
     * @var EntityRepository[]
     */
    private $repositories = [];
    /**
     * @var EntityMetadata[]
     */
    private $metadata = [];
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param string $entityName
     *
     * @return EntityRepository
     */
    public function getRepository($entityName)
    {
        if (!isset($this->repositories[$entityName])) {
            $this->repositories[$entityName] = new EntityRepository($this, $this->getMetadata($entityName));
        }

        return $this->repositories[$entityName];
    }

    /**
     * @param string $entityName
     *
     * @return EntityMetadata
     */
    public function getMetadata($entityName)
    {
        return $this->metadata[$entityName];
    }

    /**
     * @return QueryBuilder
     */
    public function createQueryBuilder()
    {
        return new QueryBuilder();
    }
}
