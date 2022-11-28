<?php

declare(strict_types=1);

namespace Filipponik\ArrayAnalyzer;

class AnalyzedCollectionFormatter
{
    /** @var array<int, AnalyzeField> */
    private array $fields;

    public function setFields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function toArray(): array
    {
        $arr = [];
        foreach ($this->fields as $fieldName => $field) {
            $arr[$fieldName] = [
                'maybeNotPresented' => $field->isMaybeNotPresented(),
                'possibleTypes' => $field->getPossibleTypes(),
                'possibleValues' => $field->getPossibleValues(),
            ];
        }

        return $arr;
    }

    public function toLaravelRulesStrings(?string $prefix = null): array
    {
        $arr = $prefix === null
            ? []
            : [$prefix => 'required|array'];

        foreach ($this->fields as $fieldName => $field) {
            $arr[$this->fiendName($field->getName(), $prefix)] = $field->getPossibleRulesInString();
        }

        return $arr;
    }

    public function toLaravelRulesArrays(?string $prefix = null): array
    {
        $arr = $prefix === null
            ? []
            : [$prefix => ['required', 'array']];
        foreach ($this->fields as $fieldName => $field) {
            $arr[$this->fiendName($field->getName(), $prefix)] = $field->getPossibleRulesInArray();
        }

        return $arr;
    }

    private function fiendName(string $fieldName, ?string $prefix = null): string
    {
        return $prefix !== null
            ? $prefix . '.*.' . $fieldName
            : $fieldName;
    }

    public function toJson(int $flags = 0): string
    {
        return json_encode($this->toArray(), $flags);
    }
}
