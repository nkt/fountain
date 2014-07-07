<?php

namespace Fountain;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class Collection implements \ArrayAccess, \JsonSerializable, \IteratorAggregate, \Countable
{
    /**
     * @var array
     */
    protected $collection = [];

    /**
     * @param array $collection
     */
    public function __construct(array $collection = [])
    {
        $this->collection = $collection;
    }

    public function __toString()
    {
        if (empty($this->collection)) {
            $id = spl_object_hash($this);
        } else {
            $element = current($this->collection);
            $id = is_object($element) ? get_class($element) : gettype($element);
        }

        return __CLASS__ . '#' . $id;
    }

    /**
     * @param mixed $key
     *
     * @return bool
     */
    public function containsKey($key)
    {
        return isset($this->collection[$key]) || array_key_exists($key, $this->collection);
    }

    /**
     * @param mixed $element
     *
     * @return bool
     */
    public function contains($element)
    {
        return in_array($element, $this->collection, true);
    }

    /**
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->containsKey($key);
    }

    /**
     * @param mixed $key
     *
     * @return mixed|null
     */
    public function get($key)
    {
        return isset($this->collection[$key]) ? $this->collection[$key] : null;
    }

    /**
     * @param mixed $key
     *
     * @return mixed|null
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->collection[$key] = $value;
    }

    /**
     * @param mixed $value
     */
    public function add($value)
    {
        $this->collection[] = $value;
    }

    /**
     * @param mixed|null $key
     * @param mixed      $value
     */
    public function offsetSet($key, $value)
    {
        if ($key === null) {
            $this->add($value);
        } else {
            $this->set($key, $value);
        }
    }

    /**
     * @param mixed $element
     */
    public function remove($element)
    {
        $key = array_search($element, $this->collection, true);
        if ($key !== false) {
            unset($this->collection[$key]);
        }
    }

    /**
     * @param mixed $key
     */
    public function removeByKey($key)
    {
        unset($this->collection[$key]);
    }

    /**
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        $this->removeByKey($key);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }

    public function isEmpty()
    {
        return empty($this->collection);
    }

    public function clear()
    {
        $this->collection = [];
    }

    public function keys()
    {
        return array_keys($this->collection);
    }

    public function count()
    {
        return count($this->collection);
    }

    public function random()
    {
        return $this->collection[array_rand($this->collection)];
    }

    public function map(\Closure $callback)
    {
        return new static(array_map($callback, $this->collection));
    }

    public function filter(\Closure $callback)
    {
        return new static(array_filter($this->collection, $callback));
    }

    public function merge(Collection $collection)
    {
        return new static(array_merge($this->collection, $collection->collection));
    }

    public function replace(Collection $collection)
    {
        return new static(array_replace($this->collection, $collection->collection));
    }

    public function reverse()
    {
        return new static(array_reverse($this->collection));
    }

    public function slice($offset, $length = null)
    {
        return new static(array_slice($this->collection, $offset, $length, true));
    }

    public function walk(\Closure $callback, $data = null)
    {
        array_walk($this->collection, $callback, $data);
    }

    public function sort(\Closure $callback)
    {
        usort($this->collection, $callback);
    }

    public function toArray()
    {
        return $this->collection;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->collection;
    }
}
