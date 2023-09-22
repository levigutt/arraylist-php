<?php

trait Set
{
    public function diff(...$arrays) : ArrayList
    {
        $arrays = array_map(fn($a) => $a instanceof ArrayList
                                        ? $a->toArray()
                                        : $a, $arrays);
        return new ArrayList(...array_diff($this->array, ...$arrays));
    }

    public function symdiff(...$arrays) : ArrayList
    {
        $arrays = array_map(fn($a) => $a instanceof ArrayList
                                        ? $a->toArray()
                                        : $a, $arrays);
        $symdiff = [];
        $arrays[] = $this->array;
        reset($arrays);
        foreach($arrays as $index => $array)
        {
            $others = array_map(fn($i) => $arrays[$i],
                          array_filter(array_keys($arrays),
                            fn($i) => $i != $index));
            foreach( array_diff($array, ...$others) as $diffval)
                $symdiff[] = $diffval;
        }
        return new ArrayList(...array_unique($symdiff));
    }

    public function intersect(...$arrays) : ArrayList
    {
        $arrays = array_map(fn($a) => $a instanceof ArrayList
                                        ? $a->toArray()
                                        : $a, $arrays);
        return new ArrayList(...array_unique(array_intersect($this->array, ...$arrays)));
    }

    public function union(...$arrays) : ArrayList
    {
        $arrays = array_map(fn($a) => $a instanceof ArrayList
                                        ? $a->toArray()
                                        : $a, $arrays);
        return new ArrayList(...array_unique(array_merge($this->array, ...$arrays)));
    }

    public function merge(...$arrays) : ArrayList
    {
        $arrays = array_map(fn($a) => $a instanceof ArrayList
                                        ? $a->toArray()
                                        : $a, $arrays);
        $this->array = array_merge($this->array, ...$arrays);
        return $this;
    }

    public function subset(array|ArrayList $set)
    {
        if ($set instanceof ArrayList)
            $set = $set->toArray();
        foreach($set as $val)
            if( !in_array($val, $this->array) )
                return false;
        return true;
    }

    public function superset(array|ArrayList $set)
    {
        if ($set instanceof ArrayList)
            $set = $set->toArray();
        foreach($this->array as $val)
            if( !in_array($val, $set) )
                return false;
        return true;
    }

    public function same(array|ArrayList $set)
    {
        if ($set instanceof ArrayList)
            $set = $set->toArray();

        foreach($set as $val)
            if( !in_array($val, $this->array) )
                return false;
        foreach($this->array as $val)
            if( !in_array($val, $set) )
                return false;
        return true;
    }

    public function identical(array|ArrayList $set)
    {
        if ($set instanceof ArrayList)
            $set = $set->toArray();

        if( count($this->array) != count($set) )
            return false;

        foreach($this->array as $index => $value)
            if( $set[$index] != $value)
                return false;

        return true;
    }
}
