<?php

namespace Fountain\Test\Connection;

use Fountain\Connection\PdoConnection;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class PdoConnectionTest extends ConnectionTest
{
    protected function createConnection()
    {
        $connection = new PdoConnection('sqlite::memory:');
        $connection->query('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username CHAR(50), email CHAR(50))');

        return $connection;
    }
}
