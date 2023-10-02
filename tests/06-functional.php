<?php
$setup or die;

# filter
$list = new ArrayList(...$numbers);
$list = $list->filter(fn($x) => $x % 2 == 0);
foreach($list as $even)
    $assert->is(0, $even % 2, "filter: $even is divisble by 2");

$list = new ArrayList(...$numbers);
$list = $list->grep(fn($x) => $x % 2 == 0);
foreach($list as $even)
    $assert->is(0, $even % 2, "grep: $even is divisble by 2");

# map
$list = new ArrayList(...$numbers);
$list = $list->map(fn($x) => $x*=7);
foreach( $list as $val )
    $assert->is(0, $val % 7, "map: $val divisible by 7");

$factors = new ArrayList(...$primes);
$list = new ArrayList(...$numbers);
$list = $list->map(fn($x, $p) => $x*=$p, $factors);
foreach($list as $val)
    $assert->is(0, $val % $factors->shift(), "$val disible by factor");

$factors = new ArrayList(...$primes);
$list = new ArrayList(...$numbers);
$list = $list->map(fn($x, $p) => $x*=$p, $primes);
foreach($list as $val)
    $assert->is(0, $val % $factors->shift(), "$val disible by factor");

# walk
$list = new ArrayList(...$names);
$list->walk(fn(&$v, $k) => $v = strtoupper($v));
$assert->is('JOHN', $list->shift(), "walk will transform values");
$assert->is('BOB', $list->shift(), "walk will transform values");

$list->walk(fn(&$v, $k) => $v = "$k:$v");
$assert->is('0:ALICE', $list->shift(), "walk has access to key");
$assert->is('1:LISA', $list->shift(), "walk has access to key");

# sort
$list = new ArrayList(...array_slice($numbers,5,6),...array_slice($numbers,0,5));
$assert->is(6, $list->at(0), "unsorted list starts at 6");
$list->sort();
$assert->is(1, $list->at(0), "sorted list starts at 1");
$list->sort(fn($a, $b) => strlen($b) <=> strlen($a));
$assert->is(10, $list->at(0), "reverse sort by strlen starts with 10");

# reduce
$list = new ArrayList(...$numbers);
$sum = $list->reduce(fn($a, $i) => $a+=$i);
$factorial = $list->reduce(fn($a, $i) => $a*=$i, 1);
$assert->is(55, $sum, "sum using ->reduce()");
$assert->is(3628800, $factorial, "factorial using ->reduce()");

# any
$list = new ArrayList(...$numbers);
$assert->ok($list->any(fn($n) => $n > 5), "should have any higher than 5");
$assert->is(false, $list->any(fn($n) => $n > 10), "shouldn't have any higher than 10");

# all
$list = new ArrayList(...$numbers);
$assert->ok($list->all(fn($n) => is_int($n)), "all should be int");
$assert->is(false, $list->all(fn($n) => is_array($n)), "all shouldn't be array");

# none
$list = new ArrayList(...$numbers);
$assert->is(false, $list->none(fn($n) => is_int($n)), "all should be int");
$assert->ok($list->none(fn($n) => is_array($n)), "all shouldn't be array");

# first
$list = new ArrayList(...$numbers);
$assert->is(6, $list->first(fn($n) => $n > 5), "first higher than 5 is 6");
$list->push('I am a string');
$assert->is('I am a string', $list->first(fn($n) => is_string($n)),
    "first string should be 'I am a string'");
$assert->is(null, $list->first(fn($n) => is_array($n)),
    "first missing returns null");
