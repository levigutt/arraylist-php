#!/usr/bin/env php
<?php

require_once "vendor/autoload.php";
require_once "t/testdata.php";
use function TestSimple\{ok, is, done_testing};

# intersect
$list = new ArrayList(...$numbers);
$inter = $list->intersect(array_slice($numbers, 0, 4), array_slice($numbers, 2, 4));
is(2, $inter->count(), "( [1,2,3,4] (|) [3,4,5,6] )->count() == 2");
is("43", $inter->pop().$inter->pop(),
                                  "( [1,2,3,4] (|) [3,4,5,6] ) == [3,4]");

$inter = $list->intersect(  new ArrayList(...array_slice($numbers, 0, 4))
                         ,  new ArrayList(...array_slice($numbers, 2, 4)));
is(2, $inter->count(),     "( [1,2,3,4] (|) [3,4,5,6] )->count() == 2");
is("34", $inter->join(''), "( [1,2,3,4] (|) [3,4,5,6] ) == [3,4]");

# union
$list = new ArrayList(1,2,3);
$union = $list->union([3,4,5]);
is(5, $union->count(),    "union removed duplicate in intersection");
ok($list->superset($union), "union is superset of original");

# merge
$list = new ArrayList(...$numbers);
$list2 = new ArrayList(...$names);
$list->merge($list2);
is($list2->pop(), $list->pop(),
    "list merged with list has new end item");
is($numbers[0], $list->shift(),
    "list merged wih list has same start item");

$list = l(...$numbers);
$list2 = [100, 200, 300];
$list->merge($list2);
is(300, $list->max(),
    "list merged with array has new max");
is($list2[count($list2)-1], $list->pop(),
    "list merged with array has new end item");
is($numbers[0], $list->shift(),
    "list merged with array has same start item");

# subset
$list = new ArrayList(...$numbers);
$set = new ArrayList(1,2,3);
ok($list->subset($set),           "1,2,3 is a subset of 1..10");
ok($list->subset([4,5]),          "[4,5] is a subset of 1..10");
ok($list->subset($numbers),       "[1..10] is a subset of 1..10");
is(false, $list->subset([0,5]),   "[0,5] is not a subset of 1..10");
is(false, $list->subset([2,11]),  "[2,11] is not a subset of 1..10");

# superset
$list = l(2,3,4,5);
ok($list->superset($numbers),          "[1..10] is superset of 2..5");
ok($list->superset(l(...$numbers)),    "(1..10) is superset of 2..5");
ok($list->superset(range(1,6)),        "[1..6] is superset of 2..5");
ok($list->superset(range(2,5)),        "[2..5] is superset of 2..5");
is(false, $list->superset(range(3,5)), "[3..5] is not superset of 2..5");
is(false, $list->superset(l(1,3,4)),   "(1,3,4) is not superset of 2..5");

# same
$list = l(1,2,3);
ok($list->same([1,2,3]),           "1..3 same as [1,2,3]");
ok($list->same(l(1,2,3)),          "1..3 same as (1,2,3)");
ok($list->same(l(3,2,1)),          "1..3 same as (3,2,1)");
ok($list->same(l(1,2,3,2,1)),      "1..3 same as (1,2,3,2,1)");
is(false, $list->same(l(0,1,2)),   "1..3 not same as (0,1,2)");
is(false, $list->same(l(1,2,3,4)), "1..3 not same as (1,2,3,4)");
is(false, $list->same(l(3)),       "1..3 not same as (3)");
is(false, $list->same(l(6)),       "1..3 not same as (6)");

# identical
$list = l(1,2,3);
ok($list->identical([1,2,3]),           "1..3 identical to [1,2,3]");
ok($list->identical(l(1,2,3)),          "1..3 identical to (1,2,3)");
is(false, $list->identical(l(3,2,1)),   "1..3 not identical to (3,2,1)");
is(false, $list->identical([1,2,3,2,1]),"1..3 not identical to [1,2,3,2,1]");
is(false, $list->identical(l(3,2,1)),   "1..3 not identical to (3,2,1)");

# diff
$list = new ArrayList(...$numbers);
$diff = $list->diff($numbers);
is(0, $diff->count(), "diff on identical returns empty");

$diff = $list->diff(array_slice($numbers, 0, 6), array_slice($numbers, 5, 4));
is(1, $diff->count(), "diff with one difference returns one");
is(10, $diff->pop(),  "diff with one difference returns missing item");

$diff = $list->diff(new ArrayList(...array_slice($numbers, 0, 6)), new ArrayList(...array_slice($numbers, 5, 4)));
is(1, $diff->count(), "diff: same count when passing ArrayList");
is(10, $diff->pop(),  "diff: same pop when passing ArrayList");

$list1 = l(2,2,3);
$list2 = l(1,1,2);
$diff = $list1->diff($list2);
is(1, $diff->count(), "diff removes duplicates");

# symmetrical diff
$list1 = l(1,2,3);
$list2 = l(2,3,4);
$diff = $list1->symdiff($list2);
is(2, $diff->count(),
    "(1,2,3) symdiff (2,3,4) == count is 2");
is("14", $diff->reduce(fn($n,$a) => $a.$n),
    "(1,2,3) symdiff (2,3,4) == 1,4");

$list3 = l(3,1,2);
$diff = $list1->symdiff($list3);
is(0, $diff->count(), "symdiff on same list has 0 results"); 

$list1 = l(2,2,3);
$list2 = l(1,1,2);
$diff = $list1->symdiff($list2);
is(2, $diff->count(), "symdiff removes duplicates");

done_testing();
