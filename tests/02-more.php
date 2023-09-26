<?php
$setup or die;

# in / contains
$list = new ArrayList(...$digits);
foreach($digits as $digit)
    $assert->ok($list->in($digit), "$digit is in list of digits");
$assert->not_ok($list->in(100), "100 is not in list of digits");

$assert->ok($list->contains($digit),  "contains is alias for in");
$assert->not_ok($list->contains(100), "contains is alias for in");

# search
$list = new ArrayList(...$digits);
$assert->ok(4 == $list->search(5), "search returns key of found item");
$assert->ok(false == $list->search(11), "search returns false when not present");

# keys
$list = (new ArrayList(...$array))->keys();
$assert->ok(0 == $list->shift(), "first key is 0");
$assert->ok(1 == $list->shift(), "second key is 1");

# values
$list = (new ArrayList(...$array))->values();
$assert->ok(1 == $list->shift(), "first value is 1");
$assert->ok(2 == $list->shift(), "second value is 2");

# join
$list = l(1,2,3);
$assert->ok("1,2,3" == $list->join(), "join uses comma by default");
$assert->ok("123" == $list->join(''), "join with emtpy string");

# reverse
$list = new ArrayList(...$digits);
$revlist = $list->reverse();
foreach($list as $val)
    $assert->ok($revlist->pop(), "list->reverse reverses list");

# slice
$list = new ArrayList(...$digits);
$list = $list->slice(7);
$assert->ok(3 == $list->count(), "slice returns from offset");
$assert->ok(8 == $list->shift(), "slice starts at offset");
$list = $list->slice(0, 1);
$assert->ok($list->count() == 1, "slice can have limit on length");

# splice
$list = new ArrayList(...$digits);
$slice = $list->splice(7);
$assert->ok(3 == $slice->count(), "splice returns slice");
$assert->ok(7 == $list->count(),  "splice cuts away from original");

$list->splice(0, 2, ['a','b']);
$assert->ok('a' == $list->shift(), "splice replaces values");
$assert->ok('b' == $list->shift(), "splice replaces values");
$assert->ok(3 == $list->shift(),   "splice replaces only specified");

# key exists
$list = new ArrayList(...$digits);
foreach($digits as $key => $val)
    $assert->ok($list->key_exists($key), "$key exists as a key");
$assert->ok(false == $list->key_exists(10), "11 does not exist as a key");

# unique
$list = new ArrayList(...$digits, ...$digits);
$assert->ok(20 == $list->count(), "count with duplicates is 20");
$unique = $list->unique();
$assert->ok(10 == $unique->count(), "count after unique() is 10");
foreach($digits as $digit)
    $assert->ok($digit == $unique->shift(), "$digit found in unique");

# fill
$list = (new ArrayList())->fill(3, 5, 'YAY');
$keys = $list->keys();
$assert->ok(3 == $keys->shift(),     "fill from 3 starts index at 3");
$assert->ok(5 == $list->count(),     "fill has correct length");
$assert->ok('YAY' == $list->pop(),   "fill sets values");
$assert->ok('YAY' == $list->shift(), "fill sets values");

