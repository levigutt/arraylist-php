# ArrayList

I made this because maps and filters are annoying to write in php.
just look at this schwartzian transform

```php
$mapped = array_map(fn($file) => [filesize($file), $file], array_filter($files, fn($file) => str_ends_with($file, ".exe")));
usort($mapped, fn($a, $b) => $a[0] <=> $b[0]);
$sorted = array_map(fn($file) => $file[1], $mapped);
```

because sort does not return a sorted array, but instead works in place, we
need a stop gap.

this is how I'd prefer to write it

```php
$sorted = $files->map(   fn($file) => [filesize($file), $file]    )
                ->filter(fn($file) => str_ends_with($file, ".exe"))
                ->sort(  fn($a,$b) => $a[0] <=> $b[0]             )
                ->map(   fn($file) => $file[1]                    );
```


```php
$cost_of_failed_orders = array_sum(array_map(fn($o) => $o->get_cost(), array_filter($orders, fn($o) => $o->is_failed())));
```

I tend to split it up to make it readable

```php
$failed_orders           = array_filter($orders, fn($o) => $o->is_failed());
$failed_order_costs      = array_map(fn($o) => $o->get_cost(), $failed_orders);
$failed_order_cost_total = array_sum($failed_order_costs);
```

but what I really prefer is to write this:
```php
$cost = $orders->filter(fn($o) => $o->is_failed())
               ->map(   fn($o) => $o->get_cost() )
               ->sum();
```


## basic usage

```php
$list = new ArrayList(10, 2, 55, 42, 69);
$new_list = $list->filter(fn($n)     => strlen($n) > 1            )
                 ->map(   fn($n)     => $n*= $n                   )
                 ->sort(  fn($a, $b) => strlen($a) <=> strlen($b) );

foreach($list as $key => $val)
    print "$key => $val\n";
```

# in-place or returning

some php functions work in the array itself, always returning true. for this
library it makes more sense to return the `ArrayList` to allow method-chaining.

this applies to: 
 - `sort`
 - `shuffle`
 - `walk`

# other differences

`->sort()` works like `usort` when given a callback.


