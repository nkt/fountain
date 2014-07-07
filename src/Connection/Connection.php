<?php


namespace Fountain\Connection;

/**
 * @author Gusakov Nikita <dev@nkt.me>
 */
interface Connection
{
    /**
     * Prepares a statement for execution and returns a Statement object.
     *
     * @param string $sql
     *
     * @return Statement
     */
    public function prepare($sql);

    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function lastInsertId($name = null);

    /**
     * Initiates a transaction.
     *
     * @throws Exception
     */
    public function beginTransaction();

    /**
     * Commits a transaction.
     *
     * @throws Exception
     */
    public function commit();

    /**
     * Rolls back the current transaction, as initiated by beginTransaction().
     *
     * @throws Exception
     */
    public function rollBack();
}
