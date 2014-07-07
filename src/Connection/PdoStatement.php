<?php

namespace Fountain\Connection;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class PdoStatement extends \PDOStatement implements Statement
{
    public function execute($parameters = null)
    {
        try {
            parent::execute($parameters);

            return $this;
        } catch (\PDOException$e) {
            throw Exception::createFromPrevious($e);
        }
    }

    public function bindValue($parameter, $value, $type = \PDO::PARAM_STR)
    {
        try {
            parent::bindValue($parameter, $value, $type);

            return $this;
        } catch (\PDOException$e) {
            throw Exception::createFromPrevious($e);
        }
    }
}
