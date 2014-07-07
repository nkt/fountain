<?php


namespace Fountain\Connection;

/**
 * @author Gusakov Nikita <dev@nkt.me>
 */
interface Statement
{
    /**
     * @param mixed $parameter Parameter identifier.
     * @param mixed $value     The value to bind to the parameter.
     * @param mixed $type      The type for binding value.
     */
    public function bindValue($parameter, $value, $type);

    /**
     * Executes a prepared statement
     *
     * @param array|null $parameters
     *
     * @return mixed
     */
    public function execute($parameters = null);
} 
