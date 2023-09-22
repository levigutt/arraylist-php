<?php
$setup or die;

# at
$list = new ArrayList(...$array);
$assert->ok(1 == $list->at(0), "1 at index 0");
$assert->ok(2 == $list->at(1), "2 at index 1");
$assert->ok(3 == $list->at(2), "3 at index 2");

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

# pop
$assert->ok(3 == $list->pop(),   "[1,2,3]->pop() returns 3");
$assert->ok(2 == $list->pop(),   "[2,3]->pop() returns 2");
$assert->ok(1 == $list->pop(),   "[3]->pop() returns 1");

# shift
$list = new ArrayList(...$array);
$assert->ok(1 == $list->shift(),   "[1,2,3]->shift() returns 1");
$assert->ok(2 == $list->shift(),   "[2,3]->shift() returns 2");
$assert->ok(3 == $list->shift(),   "[3]->shift() returns 3");

# push/pop
$list->push(1);
$list->push(2);
$list->push(3);
$assert->ok(3 == $list->pop(), "push and pop works (3)");
$assert->ok(2 == $list->pop(), "push and pop works (2)");
$assert->ok(1 == $list->pop(), "push and pop works (1)");

# shift/unshift
$list = new ArrayList(...$array);
$list->unshift(4);
$assert->ok(3 == $list->pop(), "unshift does not affect the end");
$assert->ok(4 == $list->shift(), "shift/unshift removes/adds from beginning");

