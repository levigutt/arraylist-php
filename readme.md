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

## caveats

some php functions work in the array itself, always returning true. for this
library it makes more sense to return the `ArrayList` to allow method-chaining.

this applies to:
 - `sort`
 - `shuffle`
 - `walk`

### other differences

`->sort()` works like `usort` when given a callback.

