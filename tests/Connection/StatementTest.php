<?php

namespace Fountain\Test\Connection;

use Fountain\Connection\Connection;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
abstract class StatementTest extends \PHPUnit_Framework_TestCase
{
    const PLACEHOLDER_INSERT_QUERY = 'INSERT INTO users (username, email) VALUES(?, ?)';
    const SELECT_QUERY = 'SELECT * FROM users';
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @return Connection
     */
    abstract protected function createConnection();

    protected function setUp()
    {
        $this->connection = $this->createConnection();
    }

    public function testExecute()
    {
        $stmt = $this->connection->prepare(static::PLACEHOLDER_INSERT_QUERY);

        $this->assertInstanceOf('Fountain\Connection\Statement', $stmt->execute(['nkt', 'dev@nkt.me']));

        $stmt = $this->connection->query(static::SELECT_QUERY);

        $this->assertEquals([[
            'id'       => 1,
            'username' => 'nkt',
            'email'    => 'dev@nkt.me'
        ]], $stmt->fetchAll());
    }

    public function testBindValue()
    {
        $stmt = $this->connection->prepare(static::PLACEHOLDER_INSERT_QUERY);
        $stmt->bindValue(1, 'nkt');
        $stmt->bindValue(2, 'dev@nkt.me');
        $stmt->execute();

        $stmt = $this->connection->query(static::SELECT_QUERY);

        $this->assertEquals([[
            'id'       => 1,
            'username' => 'nkt',
            'email'    => 'dev@nkt.me'
        ]], $stmt->fetchAll());
    }

    /**
     * @expectedException \Fountain\Connection\Exception
     */
    public function testExecuteError()
    {
        $stmt = $this->connection->prepare(static::PLACEHOLDER_INSERT_QUERY);
        $stmt->execute(['foo', 'bar', 'baz']);
    }

    /**
     * @expectedException \Fountain\Connection\Exception
     */
    public function testBindValueError()
    {
        $stmt = $this->connection->prepare(static::PLACEHOLDER_INSERT_QUERY);
        $stmt->bindValue(-1, 'nkt');
    }
}
