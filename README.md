# Array analyzer

Analyzes array of arrays for researching incoming data as API without documentation and not documented webhooks
Now analyzes only Collections of arrays, but in future it will analyze arrays too

## Installing
```shell
composer require filipponik/array-analyzer --dev
```


## Usage

```php
$collection = collect([
  ['a' => 1, 'b' => 2],
  ['a' => 2, 'c' => 3],
  ['a' => 3],
  ['d' => 'some_string'],
  ['e' => null],
  ['f' => 0.01],
]);

$analyzer = new \Filipponik\ArrayAnalyzer\Analyzer();
$analyzer = $analyzer->analyze($collection);
```
