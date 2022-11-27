<?php

declare(strict_types=1);

namespace Filipponik\ArrayAnalyzer;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Analyzer
{
    public function analyze(Collection $inputCollection)
    {
        $formatter = new \Filipponik\ArrayAnalyzer\AnalyzedCollectionFormatter();
        $outputCollection = new AnalyzedCollection($formatter);

        // create keys
        $inputCollection->each(function (array $item) use ($outputCollection) {
            foreach ($item as $key => $value) {
                $field = new AnalyzeField();
                $field->setName($key);
                $outputCollection->pushFieldIfNotPresented($field);
            }
        });

        // fill keys with values and types
        $outputCollection->getFields()->each(function (AnalyzeField $field) use ($inputCollection) {
            $inputCollection->each(function (array $item) use ($field) {
                if (!Arr::has($item, $field->getName())) {
                    $field->setMaybeNotPresented(true);
                } else {
                    $field->addPossibleValue(Arr::get($item, $field->getName()));
                }
            });
        });

        return $outputCollection;
    }
}