<?php
$setup or die;

# pop
$list = new ArrayList(...$array);
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

