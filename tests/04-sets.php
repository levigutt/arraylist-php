<?php
$setup or die;

# intersect
$list = new ArrayList(...$digits);
$inter = $list->intersect(array_slice($digits, 0, 4), array_slice($digits, 2, 4));
$assert->ok(2 == $inter->count(), "( [1,2,3,4] (|) [3,4,5,6] )->count() == 2");
$assert->ok("43" == $inter->pop().$inter->pop(),
                                  "( [1,2,3,4] (|) [3,4,5,6] ) == [3,4]");

$inter = $list->intersect(  new ArrayList(...array_slice($digits, 0, 4))
                         ,  new ArrayList(...array_slice($digits, 2, 4)));
$assert->ok(2 == $inter->count(),     "( [1,2,3,4] (|) [3,4,5,6] )->count() == 2");
$assert->ok("34" == $inter->join(''), "( [1,2,3,4] (|) [3,4,5,6] ) == [3,4]");

# union
$list = new ArrayList(1,2,3);
$union = $list->union([3,4,5]);
$assert->ok(5 == $union->count(),    "union removed duplicate in intersection");
$assert->ok($list->superset($union), "union is superset of original");

# merge
$list = new ArrayList(...$digits);
$list2 = new ArrayList(...$names);
$list->merge($list2);
$assert->ok($list2->pop() == $list->pop(),
    "list merged with list has new end item");
$assert->ok($digits[0] == $list->shift(),
    "list merged wih list has same start item");

$list = l(...$digits);
$list2 = [100, 200, 300];
$list->merge($list2);
$assert->ok(300 == $list->max(),
    "list merged with array has new max");
$assert->ok($list2[count($list2)-1] == $list->pop(),
    "list merged with array has new end item");
$assert->ok($digits[0] == $list->shift(),
    "list merged with array has same start item");

# subset
$list = new ArrayList(...$digits);
$set = new ArrayList(1,2,3);
$assert->ok($list->subset($set), "1,2,3 is a subset of 1..10");
$assert->ok($list->subset([4,5]),"[4,5] is a subset of 1..10");

# superset
$list = l(2,3,4,5);
$assert->ok($list->superset($digits),       "[1..10] is superset of 2..5");
$assert->ok($list->superset(l(...$digits)), "(1..10) is superset of 2..5");
$assert->ok($list->superset(range(1,6)),    "[1..6] is superset of 2..5");
$assert->ok($list->superset(range(2,5)),    "[2..5] is superset of 2..5");
$assert->not_ok($list->superset(range(3,5)),"[3..5] is not superset of 2..5");
$assert->not_ok($list->superset(l(1,3,4)),  "(1,3,4) is not superset of 2..5");

# same
$list = l(1,2,3);
$assert->ok($list->same([1,2,3]),        "1..3 same as [1,2,3]");
$assert->ok($list->same(l(1,2,3)),       "1..3 same as (1,2,3)");
$assert->ok($list->same(l(3,2,1)),       "1..3 same as (3,2,1)");
$assert->ok($list->same(l(1,2,3,2,1)),   "1..3 same as (1,2,3,2,1)");
$assert->not_ok($list->same(l(0,1,2)),   "1..3 not same as (0,1,2)");
$assert->not_ok($list->same(l(1,2,3,4)), "1..3 not same as (1,2,3,4)");
$assert->not_ok($list->same(l(3)),       "1..3 not same as (3)");
$assert->not_ok($list->same(l(6)),       "1..3 not same as (6)");

# identical
$list = l(1,2,3);
$assert->ok($list->identical([1,2,3]),        "1..3 identical to [1,2,3]");
$assert->ok($list->identical(l(1,2,3)),       "1..3 identical to (1,2,3)");
$assert->not_ok($list->identical(l(3,2,1)),   "1..3 not identical to (3,2,1)");
$assert->not_ok($list->identical([1,2,3,2,1]),"1..3 not identical to [1,2,3,2,1]");
$assert->not_ok($list->identical(l(3,2,1)),   "1..3 not identical to (3,2,1)");

# diff
$list = new ArrayList(...$digits);
$diff = $list->diff($digits);
$assert->ok(0 == $diff->count(), "diff on identical returns empty");

$diff = $list->diff(array_slice($digits, 0, 6), array_slice($digits, 5, 4));
$assert->ok(1 == $diff->count(), "diff with one difference returns one");
$assert->ok(10 == $diff->pop(),  "diff with one difference returns missing item");

$diff = $list->diff(new ArrayList(...array_slice($digits, 0, 6)), new ArrayList(...array_slice($digits, 5, 4)));
$assert->ok(1 == $diff->count(), "diff: same count when passing ArrayList");
$assert->ok(10 == $diff->pop(),  "diff: same pop when passing ArrayList");

$list1 = l(2,2,3);
$list2 = l(1,1,2);
$diff = $list1->diff($list2);
$assert->ok(1 == $diff->count(), "diff removes duplicates");

# symmetrical diff
$list1 = l(1,2,3);
$list2 = l(2,3,4);
$diff = $list1->symdiff($list2);
$assert->ok(2 == $diff->count(),
    "(1,2,3) symdiff (2,3,4) == count is 2");
$assert->ok("14" == $diff->reduce(fn($n,$a) => $a.$n),
    "(1,2,3) symdiff (2,3,4) == 1,4");

$list3 = l(3,1,2);
$diff = $list1->symdiff($list3);
$assert->not_ok($diff->count(), "symdiff on same list has 0 results"); 

$list1 = l(2,2,3);
$list2 = l(1,1,2);
$diff = $list1->symdiff($list2);
$assert->ok(2 == $diff->count(), "symdiff removes duplicates");

