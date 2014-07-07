<?php

namespace Fountain\Test\Connection;

use Fountain\Connection\Connection;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
abstract class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    const RAW_INSERT_QUERY = 'INSERT INTO users (username, email) VALUES("nkt", "dev@nkt.me")';
    const PLACEHOLDER_INSERT_QUERY = 'INSERT INTO users (username, email) VALUES(?, ?)';
    const SELECT_ALL_QUERY = 'SELECT * FROM users';
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

    public function testQuery()
    {
        $stmt = $this->connection->query(static::RAW_INSERT_QUERY);

        $this->assertInstanceOf('Fountain\Connection\Statement', $stmt);

        $stmt = $this->connection->query(static::SELECT_ALL_QUERY);

        $this->assertEquals([[
            'id'       => 1,
            'username' => 'nkt',
            'email'    => 'dev@nkt.me'
        ]], $stmt->fetchAll());
    }

    public function testPrepare()
    {
        $stmt = $this->connection->prepare(static::PLACEHOLDER_INSERT_QUERY);

        $this->assertInstanceOf('Fountain\Connection\Statement', $stmt);

        $stmt->execute(['nkt', 'dev@nkt.me']);

        $stmt = $this->connection->query(static::SELECT_ALL_QUERY);

        $this->assertEquals([[
            'id'       => 1,
            'username' => 'nkt',
            'email'    => 'dev@nkt.me'
        ]], $stmt->fetchAll());
    }

    public function testLastInsertId()
    {
        $this->connection->query(static::RAW_INSERT_QUERY);

        $this->assertEquals(1, $this->connection->lastInsertId());
    }

    public function testTransactions()
    {
        $this->connection->beginTransaction();
        $this->connection->query(static::RAW_INSERT_QUERY);
        $this->connection->rollBack();
        $stmt = $this->connection->query(static::SELECT_ALL_QUERY);

        $this->assertEmpty($stmt->fetchAll());

        $this->connection->beginTransaction();
        $this->connection->query(static::RAW_INSERT_QUERY);
        $this->connection->commit();

        $stmt = $this->connection->query(static::SELECT_ALL_QUERY);

        $this->assertNotEmpty($stmt->fetchAll());
    }

    /**
     * @expectedException \Fountain\Connection\Exception
     */
    public function testPrepareError()
    {
        $this->connection->prepare('foo-bar');
    }

    /**
     * @expectedException \Fountain\Connection\Exception
     */
    public function testQueryError()
    {
        $this->connection->query('foo-bar');
    }

    /**
     * @expectedException \Fountain\Connection\Exception
     */
    public function testBeginTransactionError()
    {
        $this->connection->beginTransaction();
        $this->connection->beginTransaction();
    }

    /**
     * @expectedException \Fountain\Connection\Exception
     */
    public function testRollbackError()
    {
        $this->connection->rollBack();
    }

    /**
     * @expectedException \Fountain\Connection\Exception
     */
    public function testCommitError()
    {
        $this->connection->commit();
    }
}
