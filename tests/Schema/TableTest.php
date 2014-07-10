<?php

namespace Fountain\Test\Schema;

use Fountain\Schema\Column;
use Fountain\Schema\Index;
use Fountain\Schema\Table;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 * @uses   \Fountain\Schema\Column
 * @uses   \Fountain\Schema\Index
 */
class TableTest extends \PHPUnit_Framework_TestCase
{
    public function testColumns()
    {
        $column = new Column('username');
        $table = new Table('users', [$column]);

        $this->assertContains($column, $table->getColumns());
        $this->assertTrue($table->hasColumn('username'));
        $this->assertFalse($table->hasColumn('password'));

        $table->addColumn(new Column('password'));

        $this->assertTrue($table->hasColumn('password'));

        $table->removeColumn('password');

        $this->assertFalse($table->hasColumn('password'));
    }

    public function testIndexes()
    {
        $columns = [new Column('username')];
        $table = new Table('users', $columns);

        $this->assertEmpty($table->getIndexes());

        $index = new Index(['username']);
        $table->addIndex($index);

        $this->assertContains($index, $table->getIndexes());

        $table->removeIndex($index->getName());

        $this->assertEmpty($table->getIndexes());

        $table = new Table('users', $columns, [$index]);

        $this->assertContains($index, $table->getIndexes());
    }

    /**
     * @expectedException \Fountain\Schema\Exception
     */
    public function testAddIndexError()
    {
        $table = new Table('users');
        $table->addIndex(new Index(['foo']));
    }

    /**
     * @expectedException \Fountain\Schema\Exception
     */
    public function testRemoveIndexError()
    {
        $table = new Table('users');
        $table->removeIndex('foo');
    }

    public function testCharset()
    {
        $table = new Table('users');

        $this->assertEquals('UTF-8', $table->getCharset());

        $table = new Table('users', [], [], [], 'win-1251');

        $this->assertEquals('win-1251', $table->getCharset());
    }

    public function testOptions()
    {
        $table = new Table('users');

        $this->assertEquals([], $table->getOptions());

        $table = new Table('users', [], [], ['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $table->getOptions());
    }

    /**
     * @dataProvider provideSchema
     */
    public function testFromArray(Table $expected, array $schema)
    {
        $this->assertEquals($expected, Table::fromArray($schema));
    }

    public function provideSchema()
    {
        $column = new Column('username');
        $index = new Index([$column->getName()]);

        return [
            [new Table('foo'), [
                'name' => 'foo'
            ]],
            [new Table('foo', [], [], ['foo' => 'bar']), [
                'name'    => 'foo',
                'options' => ['foo' => 'bar']
            ]],
            [new Table('foo', [], [], [], 'win-1251'), [
                'name'    => 'foo',
                'charset' => 'win-1251'
            ]],
            [new Table('foo', [$column]), [
                'name'    => 'foo',
                'columns' => [['name' => 'username']]
            ]],
            [new Table('foo', [$column]), [
                'name'    => 'foo',
                'columns' => ['username' => []]
            ]],
            [new Table('foo', [$column]), [
                'name'    => 'foo',
                'columns' => ['username' => $column->getType()]
            ]],
            [new Table('foo', [$column], [$index]), [
                'name'    => 'foo',
                'columns' => [['name' => 'username']],
                'indexes' => [['columns' => $column->getName()]]
            ]],
            [new Table('foo', [$column], [$index]), [
                'name'    => 'foo',
                'columns' => [['name' => 'username']],
                'indexes' => [$index->getName() => $column->getName()]
            ]],
            [new Table('foo', [$column], [$index]), [
                'name'    => 'foo',
                'columns' => [['name' => 'username']],
                'indexes' => [$index->getName() => [$column->getName()]]
            ]],
        ];
    }
}
