#!/usr/bin/env php
<?php

require_once "vendor/autoload.php";
require_once "t/testdata.php";
$assert = new TestSimple\Assert();

# in / contains
$list = new ArrayList(...$numbers);
foreach($numbers as $num)
    $assert->ok($list->in($num),   "$num is in list of numbers");
$assert->is(false, $list->in(100), "100 is not in list of numbers");

$assert->ok($list->contains($num),       "contains is alias for in");
$assert->is(false, $list->contains(100), "contains is alias for in");

# search
$list = new ArrayList(...$numbers);
$assert->is(4, $list->search(5),      "search returns key of found item");
$assert->is(false, $list->search(11), "search returns false when not present");

# keys
$list = (new ArrayList(...$array))->keys();
$assert->is(0, $list->shift(), "first key is 0");
$assert->is(1, $list->shift(), "second key is 1");

# values
$list = (new ArrayList(...$array))->values();
$assert->is(1, $list->shift(), "first value is 1");
$assert->is(2, $list->shift(), "second value is 2");

# join
$list = l(1,2,3);
$assert->is("123", $list->join(),      "join uses empty string by default");
$assert->is("1,2,3", $list->join(','), "join with commas");

# reverse
$list = new ArrayList(...$numbers);
$revlist = $list->reverse();
foreach($numbers as $val)
    $assert->is($list->shift(), $revlist->pop(), "list->reverse reverses list");

# slice
$list = new ArrayList(...$numbers);
$list = $list->slice(7);
$assert->is(3, $list->count(), "slice returns from offset");
$assert->is(8, $list->shift(), "slice starts at offset");
$list = $list->slice(0, 1);
$assert->is(1, $list->count(), "slice can have limit on length");

# splice
$list = new ArrayList(...$numbers);
$slice = $list->splice(7);
$assert->is(3, $slice->count(), "splice returns slice");
$assert->is(7, $list->count(),  "splice cuts away from original");

$list->splice(0, 2, ['a','b']);
$assert->is('a', $list->shift(), "splice replaces values");
$assert->is('b', $list->shift(), "splice replaces values");
$assert->is(3, $list->shift(),   "splice replaces only specified");

# key exists
$list = new ArrayList(...$numbers);
foreach($numbers as $key => $val)
    $assert->ok($list->key_exists($key), "$key exists as a key");
$assert->is(false, $list->key_exists(10), "11 does not exist as a key");

# unique
$list = new ArrayList(...$numbers, ...$numbers);
$assert->is(20, $list->count(), "count with duplicates is 20");
$unique = $list->unique();
$assert->is(10, $unique->count(), "count after unique() is 10");
foreach($numbers as $num)
    $assert->is($num, $unique->shift(), "$num found in unique");

# fill
$list = (new ArrayList())->fill(3, 5, 'YAY');
$keys = $list->keys();
$assert->is(3, $keys->shift(),     "fill from 3 starts index at 3");
$assert->is(5, $list->count(),     "fill has correct length");
$assert->is('YAY', $list->pop(),   "fill sets values");
$assert->is('YAY', $list->shift(), "fill sets values");

$assert->done();
