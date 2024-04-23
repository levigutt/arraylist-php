#!/usr/bin/env php
<?php

require_once "vendor/autoload.php";
require_once "t/testdata.php";
use function TestSimple\{ok, is, done_testing};

# at
$list = new ArrayList(...$array);
is(1, $list->at(0), "1 at index 0");
is(2, $list->at(1), "2 at index 1");
is(3, $list->at(2), "3 at index 2");

# set and get
$list = new ArrayList(...$array);
$list->set(1,'a');
$list->set(5,'b');
is('a', $list->get(1), "set and get works");
is('b', $list->get(5), "set and get works");

# count
$list = new ArrayList(...$array);
is($list->count(), count($array), "count is the same as ");
is($list->count(), $list->sizeof(), "sizeof is alias for count");

# iterator
$i = 0;
foreach($list as $key => $val)
{
    ok($key == $i && $val == $array[$i],
        "iterator test, $i contains $array[$i]");
    ++$i;
}

done_testing();

