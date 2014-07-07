<?php

namespace Fountain\Test;

function squaring($a)
{
    return $a * $a;
}

use Fountain\Collection;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $collection = new Collection();
        $prefix = get_class($collection) . '#';

        $this->assertEquals($prefix . spl_object_hash($collection), (string)$collection);

        $collection = new Collection(range(1, 5));

        $this->assertEquals($prefix . 'integer', (string)$collection);

        $collection = new Collection([new \stdClass()]);

        $this->assertEquals($prefix . 'stdClass', (string)$collection);
    }

    public function testContainsKey()
    {
        $collection = new Collection(['foo' => 'bar', 'bar' => null]);

        $this->assertTrue($collection->containsKey('foo'));
        $this->assertTrue($collection->containsKey('bar'));

        $this->assertTrue(isset($collection['foo']));
    }

    public function testContains()
    {
        $collection = new Collection(['foo' => 'bar', 'bar' => null]);

        $this->assertTrue($collection->contains('bar'));
        $this->assertTrue($collection->contains(null));
    }

    public function testGet()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertEquals('bar', $collection->get('foo'));
        $this->assertEquals('bar', $collection['foo']);
        $this->assertNull($collection->get('bar'));
    }

    public function testAdd()
    {
        $collection = new Collection();

        $this->assertFalse($collection->contains('foo'));

        $collection->add('foo');

        $this->assertTrue($collection->contains('foo'));

        $collection[] = 'bar';

        $this->assertTrue($collection->contains('bar'));
    }

    public function testSet()
    {
        $collection = new Collection();

        $this->assertFalse($collection->containsKey('foo'));

        $collection->set('foo', 'bar');

        $this->assertEquals('bar', $collection->get('foo'));

        $collection['foo'] = 'baz';

        $this->assertEquals('baz', $collection->get('foo'));
    }

    public function testRemove()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertTrue($collection->contains('bar'));

        $collection->remove('bar');

        $this->assertFalse($collection->contains('bar'));
    }

    public function testRemoveByKey()
    {
        $collection = new Collection(['foo' => 'bar', 'bar' => 'baz']);

        $this->assertTrue($collection->containsKey('foo'));

        $collection->removeByKey('foo');

        $this->assertFalse($collection->containsKey('foo'));

        $this->assertTrue($collection->containsKey('bar'));

        unset($collection['bar']);

        $this->assertFalse($collection->containsKey('bar'));
    }

    public function testTraversable()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertInstanceOf('Traversable', $collection);

        foreach ($collection as $key => $value) {
            $this->assertEquals($value, $collection->get($key));
        }
    }

    public function testCountable()
    {
        $collection = new Collection(range(1, 5));

        $this->assertCount(5, $collection);

        $collection->add(10);

        $this->assertCount(6, $collection);
    }

    public function testEmpty()
    {
        $collection = new Collection();

        $this->assertTrue($collection->isEmpty());

        $collection->add('foo');

        $this->assertFalse($collection->isEmpty());
    }

    public function testClear()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertFalse($collection->isEmpty());

        $collection->clear();

        $this->assertTrue($collection->isEmpty());
    }

    public function testRandom()
    {
        $collection = new Collection(range(1, 5));

        $this->assertTrue($collection->contains($collection->random()));
    }

    public function testMap()
    {
        $collection = new Collection(range(1, 3));
        $result = $collection->map(function ($a) {
            return $a * $a;
        });

        $this->assertEquals([1, 4, 9], $result->toArray());
    }

    public function testFilter()
    {
        $collection = new Collection(range(1, 5));
        $result = $collection->filter(function ($a) {
            return $a % 2 === 0;
        });

        $this->assertEquals([2, 4], array_values($result->toArray()));
    }

    public function testMerge()
    {
        $collection = new Collection(range(1, 3));
        $result = $collection->merge(new Collection(range(2, 4)));

        $this->assertEquals([1, 2, 3, 2, 3, 4], $result->toArray());
    }

    public function testReplace()
    {
        $collection = new Collection(range(1, 3));
        $result = $collection->replace(new Collection(range(3, 5)));

        $this->assertEquals([3, 4, 5], $result->toArray());
    }

    public function testReverse()
    {
        $collection = new Collection(range(1, 3));
        $result = $collection->reverse();

        $this->assertEquals([3, 2, 1], $result->toArray());
    }

    public function testSlice()
    {
        $collection = new Collection(range(1, 5));
        $result = $collection->slice(3);

        $this->assertEquals([4, 5], array_values($result->toArray()));

        $result = $collection->slice(3, 1);

        $this->assertEquals([4], array_values($result->toArray()));
    }

    public function testWalk()
    {
        $collection = new Collection(range(1, 3));
        $collection->walk(function (&$a) {
            $a *= $a;
        });

        $this->assertEquals([1, 4, 9], $collection->toArray());
    }

    public function testSort()
    {
        $array = range(1, 10);
        shuffle($array);
        $collection = new Collection($array);
        $collection->sort(function ($a, $b) {
            return $a === $b ? 0 : $a > $b ? 1 : -1;
        });

        $this->assertEquals(range(1, 10), $collection->toArray());
    }
}
