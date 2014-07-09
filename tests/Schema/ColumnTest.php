<?php

namespace Fountain\Test\Schema;

use Fountain\Schema\Column;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class ColumnTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $column = new Column('foo');

        $this->assertSame('foo', $column->getName());

        $column->setName('bar');

        $this->assertSame('bar', $column->getName());
    }

    public function testType()
    {
        $column = new Column('foo');

        $this->assertSame('string', $column->getType());

        $column->setType('int');

        $this->assertSame('int', $column->getType());

        $column = new Column('foo', 'float');

        $this->assertSame('float', $column->getType());
    }

    public function testLength()
    {
        $column = new Column('foo');

        $this->assertNull($column->getLength());

        $column->setLength(100);

        $this->assertSame(100, $column->getLength());

        $column = new Column('foo', null, 255);

        $this->assertSame(255, $column->getLength());
    }

    public function testNullable()
    {
        $column = new Column('foo');

        $this->assertFalse($column->isNullable());

        $column->setNullable(true);

        $this->assertTrue($column->isNullable());

        $column = new Column('foo', null, null, true);

        $this->assertTrue($column->isNullable());
    }

    public function testDefault()
    {
        $column = new Column('foo');

        $this->assertNull($column->getDefault());

        $column->setDefault('no');

        $this->assertSame('no', $column->getDefault());

        $column = new Column('foo', null, null, null, 'yes');

        $this->assertSame('yes', $column->getDefault());
    }

    public function testPrecision()
    {
        $column = new Column('foo');

        $this->assertSame(10, $column->getPrecision());

        $column->setPrecision(5);

        $this->assertSame(5, $column->getPrecision());
    }

    public function testUnsigned()
    {
        $column = new Column('foo');

        $this->assertFalse($column->isUnsigned());

        $column->setUnsigned(true);

        $this->assertTrue($column->isUnsigned());
    }

    public function testComment()
    {
        $column = new Column('foo');

        $this->assertNull($column->getComment());

        $column->setComment('bar');

        $this->assertSame('bar', $column->getComment());
    }

    public function testOptions()
    {
        $column = new Column('foo');

        $this->assertSame([], $column->getOptions());

        $column->setOptions(['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], $column->getOptions());
    }

    /**
     * @dataProvider provideSchema
     */
    public function testFromArray(Column $expected, array $schema)
    {
        $this->assertEquals($expected, Column::fromArray($schema));
    }

    public function provideSchema()
    {
        $precision = new Column('foo');
        $precision->setPrecision(5);
        $unsigned = new Column('foo');
        $unsigned->setUnsigned(true);
        $comment = new Column('foo');
        $comment->setComment('bar');
        $options = new Column('foo');
        $options->setOptions(['foo' => 'bar']);

        return [
            [new Column('foo'), ['name' => 'foo']],
            [new Column('foo', 'float'), ['name' => 'foo', 'type' => 'float']],
            [new Column('foo', null, 255), ['name' => 'foo', 'length' => 255]],
            [new Column('foo', null, null, true), ['name' => 'foo', 'nullable' => true]],
            [new Column('foo', null, null, null, 'bar'), ['name' => 'foo', 'default' => 'bar']],
            [$precision, ['name' => 'foo', 'precision' => 5]],
            [$unsigned, ['name' => 'foo', 'unsigned' => true]],
            [$comment, ['name' => 'foo', 'comment' => 'bar']],
            [$options, ['name' => 'foo', 'options' => ['foo' => 'bar']]],
        ];
    }
}
