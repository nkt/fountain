<?php

namespace Fountain\Test\Schema;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class SchemaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Fountain\Schema\Schema
     */
    protected $schema;

    protected function setUp()
    {
        $this->schema = $this->getMockForAbstractClass('Fountain\Schema\Schema');
    }

    public function testName()
    {
        $this->assertNull($this->schema->getName());

        $this->schema->setName('foo');

        $this->assertEquals('foo', $this->schema->getName());
    }

    public function testCharset()
    {
        $this->assertEquals('UTF-8', $this->schema->getCharset());

        $this->schema->setCharset('foo');

        $this->assertEquals('foo', $this->schema->getCharset());
    }
}
