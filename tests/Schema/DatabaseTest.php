<?php

namespace Fountain\Test\Schema;

use Fountain\Schema\Database;
use Fountain\Schema\Table;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 * @uses   \Fountain\Schema\Table
 */
class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $database = new Database('foo');

        $this->assertEquals('foo', $database->getName());
    }

    public function testCharset()
    {
        $database = new Database('foo');

        $this->assertNotNull($database->getCharset());

        $database = new Database('foo', [], 'win-1251');

        $this->assertEquals('win-1251', $database->getCharset());
    }

    public function testAddTable()
    {
        $database = new Database('foo', []);

        $this->assertEquals([], $database->getTables());

        $table = new Table('users');
        $database = new Database('foo', [$table]);

        $this->assertContains($table, $database->getTables());
        $this->assertEquals($table, $database->getTable($table->getName()));
    }

    public function testRemoveTable()
    {
        $table = new Table('users');
        $database = new Database('foo', [$table]);

        $database->removeTable($table->getName());

        $this->assertNotContains($table, $database->getTables());
    }

    /**
     * @expectedException \Fountain\Schema\Exception
     */
    public function testGetTableError()
    {
        $database = new Database('foo', []);
        $database->getTable('users');
    }

    /**
     * @expectedException \Fountain\Schema\Exception
     */
    public function testRemoveTableError()
    {
        $database = new Database('foo', []);
        $database->removeTable('users');
    }
}
