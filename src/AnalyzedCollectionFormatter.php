<?php

declare(strict_types=1);

namespace Filipponik\ArrayAnalyzer;

use Illuminate\Support\Collection;

class AnalyzedCollectionFormatter
{
    private Collection $fields;

    public function setFields(Collection $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function toArray(): array
    {
        $arr = [];
        foreach ($this->fields as $fieldName => $field) {
            /** @var AnalyzeField $field */
            $preparedArr['name'] = $fieldName;
            $preparedArr['maybeNotPresented'] = $field->isMaybeNotPresented();
            $preparedArr['possibleTypes'] = $field->getPossibleTypes();
            $preparedArr['possibleValues'] = $field->getPossibleValues();

            $arr[$fieldName] = $preparedArr;
        }

        return $arr;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}