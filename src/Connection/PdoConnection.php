<?php

namespace Fountain\Connection;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class PdoConnection extends \PDO implements Connection
{
    /**
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param array  $options
     */
    public function __construct($dsn, $username = null, $password = null, $options = [])
    {
        parent::__construct($dsn, $username, $password, array_replace($options, [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_STATEMENT_CLASS    => ['Fountain\\Connection\\PdoStatement'],
        ]));
    }

    public function prepare($sql, $driverOptions = [])
    {
        try {
            return parent::prepare($sql, $driverOptions);
        } catch (\PDOException $e) {
            throw Exception::createFromPrevious($e);
        }
    }

    public function query()
    {
        $args = func_get_args();
        try {
            switch (func_num_args()) {
                case 1:
                    return parent::query($args[0]);
                case 2:
                    return parent::query($args[0], $args[1]);
                case 3:
                    return parent::query($args[0], $args[1], $args[2]);
                case 4:
                    return parent::query($args[0], $args[1], $args[2], $args[3]);
            }
        } catch (\PDOException $e) {
            throw Exception::createFromPrevious($e);
        }
    }

    public function beginTransaction()
    {
        try {
            parent::beginTransaction();
        } catch (\PDOException $e) {
            throw Exception::createFromPrevious($e);
        }
    }

    public function commit()
    {
        try {
            parent::commit();
        } catch (\PDOException $e) {
            throw Exception::createFromPrevious($e);
        }
    }

    public function rollback()
    {
        try {
            parent::rollBack();
        } catch (\PDOException $e) {
            throw Exception::createFromPrevious($e);
        }
    }
}
