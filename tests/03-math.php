<?php
$setup or die;

# sum
$list = new ArrayList(...$digits);
$assert->ok(55 == $list->sum(),                   "[1..10]->sum() == 55");
$assert->ok(10 == (new ArrayList(1,2,3,4))->sum(), "[1,2,3,4]->sum() == 10");

# product
$list = new ArrayList(...$digits);
$assert->ok(3628800 == $list->product(), "[1..10]->product = 3628800");

# min
$list = new ArrayList(...$digits);
$assert->ok(1 == $list->min(), "min should be 1");
$list->push(-3);
$assert->ok(-3 == $list->min(), "min should be -3");

# max
$assert->ok(10 == $list->max(), "max should be 10");
$list->unshift(15);
$assert->ok(15 == $list->max(), "max should be 15");

# avg (mean)
$list = new ArrayList(...$digits);
$assert->ok(5.5 == $list->avg(),                    "[1..10]->avg() == 5.5");
$assert->ok($list->mean() == $list->avg(),          "mean is alias for avg");
$assert->ok(2.5 == (new ArrayList(1,2,3,4))->avg(), "[1,2,3,4]->avg() == 2.5");

$list = new ArrayList(...$digits, ...range('a','z'));
$assert->ok(5.5 == $list->avg(),
    "non-numeric values are ignored in avg()");
$list = new ArrayList(...range('a', 'z'));
$assert->ok(0 == $list->avg(),
    "all non-numeric values result in 0 in avg()");

# median
$list = new ArrayList(1,2,3,4,5);
$assert->ok(3 == $list->median(),   "[1,2,3,4,5]->median() == 3");
$list->pop();
$assert->ok(2.5 == $list->median(), "[1,2,3,4]->median() == 2.5");

# mode
$list = new ArrayList(1,2,3,3,4,5);
$assert->ok(3 == $list->mode(), "mode returns single value of highest occurence");
$list = new ArrayList(10,4,1,1,2,3,4,5,10,7,8);
$assert->ok(l(1,4,10)->sort()->identical($list->mode()->sort()),
    "mode returns subset with same highest occurrence");
$list = new ArrayList(1,2,3,4,5);
$assert->ok($list->sort()->identical($list->mode()->sort()),
    "mode returns all with same highest occurrence");

