# ArrayList

this library lets you create objects that work like arrays, and has methods for most array functions in php.

this results in more readable and declarative code.

## examples

**sort all executable files**

regular php:

```php
$executables = array_filter($files, fn($file) => str_ends_with($file, ".exe"));
$mapped = array_map(fn($file) => [filesize($file), $file], $executables);
usort($mapped, fn($a, $b) => $a[0] <=> $b[0]);
$sorted_executables = array_map(fn($file) => $file[1], $mapped);
```

using arraylist:

```php
$list = new ArrayList(...$files);
$sorted_executables = $list->filter(fn($file) => str_ends_with($file, ".exe"))
                           ->map(   fn($file) => [filesize($file), $file]    )
                           ->sort(  fn($a,$b) => $a[0] <=> $b[0]             )
                           ->map(   fn($file) => $file[1]                    );
```

**build string of random letters**

regular php:

```php
$alphabet = range('a', 'z');
$str = '';
while(strlen($str) < 12)
    $str.= $alphabet[rand(0, count($alphabet)-1)];
```

using arraylist:

```php
$alpha = new ArrayList(...range('a','z'));
$str = $alpha->roll(12)->join('');
```

**root mean squared**

regular php:

```php
$numbers = range(1,10);
$r = 0;
foreach($numbers as $num)
    $r += $num ** 2;
$rms = sqrt($r / count($numbers));
printf("%.13f\n", $rms);
```


using arraylist:
```
$numbers = new ArrayList(...range(1,10));
$rms = sqrt( $numbers->map(fn($n) => $n**2)->avg() );
printf("%.13f\n", $rms);
```

## caveats

some php functions work in the array itself, always returning true. to make
sense as methods they'll return the list itself - this allows them to be
chained with other methods.

this applies to:
 - `sort`
 - `shuffle`
 - `walk`

### other differences

`->sort()` works like `usort` when given a callback.

