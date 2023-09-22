<?php

trait Stack
{
    public function pop()
    {
        return array_pop($this->array);
    }

    public function push(mixed $val) : void
    {
        array_push($this->array, $val);
    }

    public function shift() : mixed
    {
        return array_shift($this->array);
    }

    public function unshift(mixed $val) : void
    {
        array_unshift($this->array, $val);
    }
}
