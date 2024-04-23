#!/usr/bin/env php
<?php

require_once "vendor/autoload.php";
require_once "t/testdata.php";
use function TestSimple\{ok, is, done_testing};

# sum
$list = new ArrayList(...$numbers);
is(55, $list->sum(),                   "[1..10]->sum() == 55");
is(10, (new ArrayList(1,2,3,4))->sum(), "[1,2,3,4]->sum() == 10");

# product
$list = new ArrayList(...$numbers);
is(3628800, $list->product(), "[1..10]->product = 3628800");

# min
$list = new ArrayList(...$numbers);
is(1, $list->min(), "min should be 1");
$list->push(-3);
is(-3, $list->min(), "min should be -3");

# max
is(10, $list->max(), "max should be 10");
$list->unshift(15);
is(15, $list->max(), "max should be 15");
$list->push(20);
is(20, $list->max(), "max should be 20");

# mean (avg)
$list = new ArrayList(...$numbers);
is(5.5, $list->avg(),                    "[1..10]->avg() == 5.5");
is($list->mean(), $list->avg(),          "mean is alias for avg");
is(2.5, (new ArrayList(1,2,3,4))->avg(), "[1,2,3,4]->avg() == 2.5");

$list = new ArrayList(...$numbers, ...range('a','z'));
is(5.5, $list->avg(),
    "non-numeric values are ignored in avg()");
$list = new ArrayList(...range('a', 'z'));
is(0, $list->avg(),
    "all non-numeric values result in 0 in avg()");

# median
$list = new ArrayList(1,2,3,4,5);
is(3, $list->median(),   "[1,2,3,4,5]->median() == 3");
$list->pop();
is(2.5, $list->median(), "[1,2,3,4]->median() == 2.5");

# mode
$list = new ArrayList(1,2,3,3,4,5);
is(3, $list->mode(), "mode returns single value of highest occurence");
$list = new ArrayList(10,4,1,1,2,3,4,5,10,7,8);
ok(l(1,4,10)->sort()->identical($list->mode()->sort()),
    "mode returns subset with same highest occurrence");
$list = new ArrayList(1,2,3,4,5);
ok($list->sort()->identical($list->mode()->sort()),
    "mode returns all with same highest occurrence");

done_testing();
