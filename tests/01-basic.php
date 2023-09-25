<?php
$setup or die;

# at
$list = new ArrayList(...$array);
$assert->ok(1 == $list->at(0), "1 at index 0");
$assert->ok(2 == $list->at(1), "2 at index 1");
$assert->ok(3 == $list->at(2), "3 at index 2");

# set and get
$list = new ArrayList(...$array);
$list->set(1,'a');
$list->set(5,'b');
$assert->ok('a' == $list->get(1), "set and get works");
$assert->ok('b' == $list->get(5), "set and get works");

# count
$list = new ArrayList(...$array);
$assert->ok($list->count() == count($array), "count is the same as ");
$assert->ok($list->count() == $list->sizeof(), "sizeof is alias for count");

# iterator
$i = 0;
foreach($list as $key => $val)
{
    $assert->ok($key == $i && $val == $array[$i],
        "iterator test, $i contains $array[$i]");
    ++$i;
}

