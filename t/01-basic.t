#!/usr/bin/env php
<?php

require_once "vendor/autoload.php";
require_once "t/testdata.php";
$assert = new TestSimple\Assert();

# at
$list = new ArrayList(...$array);
$assert->is(1, $list->at(0), "1 at index 0");
$assert->is(2, $list->at(1), "2 at index 1");
$assert->is(3, $list->at(2), "3 at index 2");

# set and get
$list = new ArrayList(...$array);
$list->set(1,'a');
$list->set(5,'b');
$assert->is('a', $list->get(1), "set and get works");
$assert->is('b', $list->get(5), "set and get works");

# count
$list = new ArrayList(...$array);
$assert->is($list->count(), count($array), "count is the same as ");
$assert->is($list->count(), $list->sizeof(), "sizeof is alias for count");

# iterator
$i = 0;
foreach($list as $key => $val)
{
    $assert->ok($key == $i && $val == $array[$i],
        "iterator test, $i contains $array[$i]");
    ++$i;
}

$assert->done();

