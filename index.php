<?php
declare(strict_types=1);
require __DIR__.'/vendor/autoload.php';

$testArray = collect([
    [
        'a' => [
            'b' => 1,
            'c' => 3,
        ],
        'd' => 15,
        'e' => null,
    ],
    [
        'a' => [
            'b' => 2,
        ],
        'e' => 'kek',
    ],
    [
        'a' => [
            'b' => 2,
        ],
        'e' => 1,
    ],
    [
        'ff' => 1,
        'a' => [
            'b' => 3,
            'c' => 5,
        ],
    ],
]);

$analyzer = new \Filipponik\ArrayAnalyzer\Analyzer();
echo $analyzer->analyze($testArray)->toJson();
