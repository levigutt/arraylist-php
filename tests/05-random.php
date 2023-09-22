<?php
$setup or die;

# shuffle
$repeat = 1000;
$count = 0;
$value = $digits[array_rand($digits)]; # pick random value
while($repeat--)
{
    $list = new ArrayList(...$digits);
    $list->shuffle();
    if( $value == $list->pop() )
        $count++;
}
$assert->ok($count > 75 && $count < 125,
    "shuffle n=10 should pop a specific value ~10% of the time");

# rand
$repeat = 1000;
$count = 0;
$key = array_rand($digits); # pick random key
while($repeat--)
{
    $list = new ArrayList(...$digits);
    if( $key == $list->rand() )
        $count++;
}
$assert->ok($count > 75 && $count < 125,
    "rand n=10 should give a specific key ~10% of the time");

# pick
$repeat = 1000;
$count = 0;
$value = $digits[array_rand($digits)]; # pick random value
while($repeat--)
{
    $list = new ArrayList(...$digits);
    if( $value == $list->pick() )
        $count++;
}
$assert->ok($count > 75 && $count < 125,
    "pick n=10 should give a specific value ~10% of the time");
