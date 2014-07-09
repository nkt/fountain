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

    public function bindValue($parameter, $value, $type = null)
    {
        try {
            parent::bindValue($parameter, $value, $type === null ? \PDO::PARAM_STR : $type);

            return $this;
        } catch (\PDOException$e) {
            throw Exception::createFromPrevious($e);
        }
    }
}
