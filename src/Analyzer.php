<?php

declare(strict_types=1);

namespace Filipponik\ArrayAnalyzer;

class Analyzer
{
    public function analyze(array $arrayOfArrays): AnalyzedCollection
    {
        $formatter = new AnalyzedCollectionFormatter();
        $outputCollection = new AnalyzedCollection($formatter);

        // create keys
        foreach ($arrayOfArrays as $item) {
            foreach (array_keys($item) as $key) {
                $field = new AnalyzeField();
                $field->setName($key);
                $outputCollection->pushFieldIfNotPresented($field);
            }
        }

        foreach ($outputCollection->getFields() as $field) {
            foreach ($arrayOfArrays as $item) {
                if (!in_array($field->getName(), $item, true)) {
                    $field->setMaybeNotPresented(true);
                } else {
                    $field->addPossibleValue($item[$field->getName()]);
                }
            }
        }

        return $outputCollection;
    }
}
