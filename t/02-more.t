#!/usr/bin/env php
<?php

require_once "vendor/autoload.php";
require_once "t/testdata.php";
use function TestSimple\{ok, is, done_testing};

# in / contains
$list = new ArrayList(...$numbers);
foreach($numbers as $num)
    ok($list->in($num),   "$num is in list of numbers");
is(false, $list->in(100), "100 is not in list of numbers");

ok($list->contains($num),       "contains is alias for in");
is(false, $list->contains(100), "contains is alias for in");

# search
$list = new ArrayList(...$numbers);
is(4, $list->search(5),      "search returns key of found item");
is(false, $list->search(11), "search returns false when not present");

# keys
$list = (new ArrayList(...$array))->keys();
is(0, $list->shift(), "first key is 0");
is(1, $list->shift(), "second key is 1");

# values
$list = (new ArrayList(...$array))->values();
is(1, $list->shift(), "first value is 1");
is(2, $list->shift(), "second value is 2");

# join
$list = l(1,2,3);
is("123", $list->join(),      "join uses empty string by default");
is("1,2,3", $list->join(','), "join with commas");

# reverse
$list = new ArrayList(...$numbers);
$revlist = $list->reverse();
foreach($numbers as $val)
    is($list->shift(), $revlist->pop(), "list->reverse reverses list");

# slice
$list = new ArrayList(...$numbers);
$list = $list->slice(7);
is(3, $list->count(), "slice returns from offset");
is(8, $list->shift(), "slice starts at offset");
$list = $list->slice(0, 1);
is(1, $list->count(), "slice can have limit on length");

# splice
$list = new ArrayList(...$numbers);
$slice = $list->splice(7);
is(3, $slice->count(), "splice returns slice");
is(7, $list->count(),  "splice cuts away from original");

$list->splice(0, 2, ['a','b']);
is('a', $list->shift(), "splice replaces values");
is('b', $list->shift(), "splice replaces values");
is(3, $list->shift(),   "splice replaces only specified");

# key exists
$list = new ArrayList(...$numbers);
foreach($numbers as $key => $val)
    ok($list->key_exists($key), "$key exists as a key");
is(false, $list->key_exists(10), "11 does not exist as a key");

# unique
$list = new ArrayList(...$numbers, ...$numbers);
is(20, $list->count(), "count with duplicates is 20");
$unique = $list->unique();
is(10, $unique->count(), "count after unique() is 10");
foreach($numbers as $num)
    is($num, $unique->shift(), "$num found in unique");

# fill
$list = (new ArrayList())->fill(3, 5, 'YAY');
$keys = $list->keys();
is(3, $keys->shift(),     "fill from 3 starts index at 3");
is(5, $list->count(),     "fill has correct length");
is('YAY', $list->pop(),   "fill sets values");
is('YAY', $list->shift(), "fill sets values");

# chunk
$list = l(...$numbers);
is(count($numbers), $list->chunk(1)->count(),
    "chunk with 1 length returns same length");
is(count($numbers)/2, $list->chunk(2)->count(),
    "chunk with 2 length returns half the length");
is((int)ceil(count($numbers)/3), $list->chunk(3)->count(),
    "chunk rounds up when not evenly divisible");

# column
$list = new ArrayList(...[   ['key1' => 'a', 'key2' => 'A']
                         ,   ['key1' => 'b', 'key2' => 'B']
                         ]);
is(['a', 'b'], $list->column('key1')->toArray(),
    "column gets the values for the first key");
is(['A', 'B'], $list->column('key2')->toArray(),
    "column gets the values for the second key");

done_testing();
