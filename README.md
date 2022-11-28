# Array analyzer

Analyzes array of arrays for researching incoming data as API without documentation and not documented webhooks

## Installing

```shell
composer require filipponik/array-analyzer --dev
```

## Usage

```php
$arrayOfArrays = [
  ['a' => 1, 'b' => 2],
  ['a' => 2, 'c' => 3],
  ['a' => 3],
  ['d' => 'some_string'],
  ['e' => null],
  ['f' => 0.01],
];

$analyzer = new \Filipponik\ArrayAnalyzer\Analyzer();
$analyzedCollection = $analyzer->analyze($arrayOfArrays);

$result = $analyzedCollection->toArray(); // analyzing result
$rules = $analyzer->toLaravelRulesStrings(); // possible laravel validation rules in format 'required|string'
$rules = $analyzer->toLaravelRulesArrays(); // possible laravel validation rules in format ['required', 'string']
```
