<?php

class ArrayList implements \Countable, \Iterator, \Stringable
{
    private array $array;
    private int $current = 0;

    use Stack;
    use Set;

    public function __construct(...$args)
    {
        $this->array = $args;
    }

    public function toArray() : array
    {
        return $this->array;
    }

    ########### STRINGABLE ###########

    public function __toString()
    {
        return print_r($this->array, true);
    }

    ########### COUNTABLE ###########
    public function count() : int
    {
        return count($this->array);
    }
    public function sizeof() : int { return $this->count(); }

    ########### ITERATOR ###########
    public function current() : mixed
    {
        return $this->array[$this->current];
    }
    public function pos() : mixed { return $this->current(); }

    public function next() : void
    {
        ++$this->current;
    }

    public function key() : mixed
    {
        return $this->current;
    }

    public function valid() : bool
    {
        return isset($this->array[$this->current]);
    }

    public function rewind() : void
    {
        $this->current = 0;
    }

    private function reset() : void
    {
        $this->current = 0;
    }

    ########### BASIC METHODS ###########

    public function in(mixed $needle) : bool
    {
        return in_array($needle, $this->array);
    }
    public function contains(...$args) : bool { return $this->in(...$args); }

    public function key_exists(mixed $key) : bool
    {
        return array_key_exists($key, $this->array);
    }

    ########### EXTRACTING METHODS ###########

    public function get(mixed $key) : mixed
    {
        return $this->array[$key];
    }
    public function at(...$args) : mixed { return $this->get(...$args); }

    public function search(mixed $needle) : mixed
    {
        return array_search($needle, $this->array);
    }

    public function keys() : ArrayList
    {
        return new ArrayList(...array_keys($this->array));
    }

    public function values() : ArrayList
    {
        return new ArrayList(...array_values($this->array));
    }

    public function sum() : int|float
    {
        return array_sum($this->array);
    }

    public function implode(string $separator = ',') : string
    {
        return implode($separator, $this->array);
    }
    public function join(...$args) : string { return $this->implode(...$args); }

    public function reverse() : ArrayList
    {
        return new ArrayList(...array_reverse($this->array));
    }

    public function slice(int $offset, ...$args) : ArrayList
    {
        return new ArrayList(...array_slice($this->array, $offset, ...$args));
    }

    public function splice(int $offset, ...$args) : ArrayList
    {
        $slice = array_splice($this->array, $offset, ...$args);
        return new ArrayList(...$slice);
    }

    public function min()
    {
        return min(...$this->array);
    }

    public function max()
    {
        return max(...$this->array);
    }

    public function unique(int $flags = SORT_STRING) : ArrayList
    {
        return new ArrayList(...array_unique($this->array, $flags));
    }

    ########### POPULATING METHODS ###########

    public function set(mixed $key, mixed $val) : ArrayList
    {
        $this->array[$key] = $val;
        return $this;
    }

    public function fill(...$args) : ArrayList
    {
        $this->array = array_fill(...$args);
        return $this;
    }

    ########### RANDOMNESS ###########

    public function rand(int $num = 1) : mixed
    {
        return array_rand($this->array, $num);
    }

    public function pick() : mixed
    {
        return $this->array[array_rand($this->array)];
    }

    public function shuffle() : ArrayList
    {
        shuffle($this->array);
        return $this;
    }

    ########### FUNCTIONAL METHODS ###########

    public function sort(Callable $cb = null) : ArrayList
    {
        if( $cb )
            usort($this->array, $cb);
        else
            sort($this->array);
        return $this;
    }

    public function filter(Callable $cb, ...$args) : ArrayList
    {
        return new ArrayList(...array_filter($this->array, $cb, ...$args));
    }
    public function grep(...$args) : ArrayList { return $this->filter(...$args); }

    public function map(Callable $cb, ...$arrays) : ArrayList
    {
        $arrays = array_map(fn($a) => $a instanceof ArrayList
                                        ? $a->toArray()
                                        : $a, $arrays);
        return new ArrayList(...array_map($cb, $this->array, ...$arrays));
    }

    public function reduce(Callable $cb, mixed $initial = null) : mixed
    {
        return array_reduce($this->array, $cb, $initial);
    }

    public function any(Callable $cb) : bool
    {
        return !!array_sum(array_map($cb, $this->array));
    }

    public function all(Callable $cb) : bool
    {
        return count($this->array) == array_sum(array_map($cb, $this->array));
    }

    public function none(Callable $cb) : bool
    {
        return !$this->all($cb);
    }

    public function first(Callable $cb) : mixed
    {
        return $this->filter($cb)->shift();
    }

    public function walk(Callable $cb) : ArrayList
    {
        array_walk($this->array, $cb);
        return $this;
    }
}
