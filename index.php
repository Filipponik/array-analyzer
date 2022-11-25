<?php
declare(strict_types=1);
require __DIR__.'/vendor/autoload.php';

$testArray = [
    [
        'a' => [
            'b' => 1,
            'c' => 3,
        ],
        'd' => 15,
    ],
    [
        'a' => [
            'b' => 2,
        ],
    ],
    [
        'e' => 1,
    ],
    [
        'ff' => 1,
        'a' => [
            'b' => 3,
            'c' => 5,
        ],
    ],
];

dd($testArray);