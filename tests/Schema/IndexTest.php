<?php

namespace Fountain\Test\Schema;

use Fountain\Schema\Index;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class IndexTest extends \PHPUnit_Framework_TestCase
{
    public function testColumns()
    {
        $index = new Index(['foo']);

        $this->assertNotEmpty($index->getColumns());
        $this->assertTrue($index->hasColumn('foo'));
        $this->assertContains('foo', $index->getColumns());

        $index->addColumn('bar');

        $this->assertContains('bar', $index->getColumns());
        $this->assertTrue($index->hasColumn('bar'));
        $this->assertContains('bar', $index->getColumns());
    }

    public function testName()
    {
        $index = new Index(['foo']);

        $this->assertEquals('index_foo', $index->getName());

        $index = new Index(['foo'], 'bar');

        $this->assertEquals('bar', $index->getName());
    }

    /**
     * @dataProvider provideTypes
     */
    public function testType($constructType, $type, $isIndex, $isUnique, $isPrimary)
    {
        $index = new Index(['foo'], null, $constructType);

        $this->assertEquals($type, $index->getType());
        $this->assertEquals($isIndex, $index->isIndex());
        $this->assertEquals($isUnique, $index->isUnique());
        $this->assertEquals($isPrimary, $index->isPrimary());
    }

    public function provideTypes()
    {
        return [
            [null, 'index', true, false, false],
            ['index', 'index', true, false, false],
            ['unique', 'unique', false, true, false],
            ['primary', 'primary', false, false, true],
            ['fulltext', 'fulltext', false, false, false]
        ];
    }

    /**
     * @dataProvider provideSchema
     */
    public function testCreateIndexFromArray(Index $expected, array $schema)
    {
        $this->assertEquals($expected, Index::fromArray($schema));
    }

    public function provideSchema()
    {
        return [
            [new Index(['foo'], 'foo'), ['name' => 'foo', 'columns' => ['foo']]],
            [new Index(['foo']), ['columns' => ['foo']]],
            [new Index(['foo'], null, 'primary'), ['columns' => ['foo'], 'type' => 'primary']]
        ];
    }

    /**
     * @expectedException \Fountain\Schema\Exception
     */
    public function testIndexCanNotBeCreatedWithoutColumns()
    {
        new Index([]);
    }
}
