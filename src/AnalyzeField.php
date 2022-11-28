<?php

declare(strict_types=1);

namespace Filipponik\ArrayAnalyzer;

class AnalyzeField
{
    public const NOT_FOR_RULES_TYPES = [
        'object',
        'double',
        'float',
    ];

    private string $name;

    private array $possibleTypes = [];

    private array $possibleValues = [];

    private bool $maybeNotPresented = false;

    public function getPossibleTypes(): array
    {
        return $this->possibleTypes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPossibleValues(): array
    {
        return $this->possibleValues;
    }

    public function addPossibleValue($possibleValue): void
    {
        // add value if not presented
        if (!$this->checkInPossibleValues($possibleValue)) {
            $this->possibleValues[] = $possibleValue;
            // add type if not presented
            if (!$this->checkInPossibleTypes(gettype($possibleValue))) {
                $this->possibleTypes[] = gettype($possibleValue);
            }
        }
    }

    public function isMaybeNotPresented(): bool
    {
        return $this->maybeNotPresented;
    }

    public function setMaybeNotPresented(bool $maybeNotPresented): void
    {
        $this->maybeNotPresented = $maybeNotPresented;
    }

    public function checkInPossibleValues($value): bool
    {
        return in_array($value, $this->possibleValues, true);
    }

    public function checkInPossibleTypes($value): bool
    {
        return in_array($value, $this->possibleTypes, true);
    }

    public function getPossibleRulesInString(): string
    {
        return implode('|', $this->getPossibleRulesInArray());
    }

    public function getPossibleRulesInArray(): array
    {
        $rules = [];

        // check if value is required
        if (!$this->maybeNotPresented) {
            $rules[] = 'required';
        }

        // fill possible types
        foreach ($this->possibleTypes as $possibleType) {
            if (!in_array(self::NOT_FOR_RULES_TYPES, $possibleType, true)) {
                $rules[] = $possibleType === 'NULL' ? 'nullable' : $possibleType;
            }
        }

        $isAllNumeric = true;
        $isAllUUID = true;
        foreach ($this->possibleValues as $value) {
            if (!is_numeric($value)) {
                $isAllNumeric = false;
            }
        }

        if ($isAllNumeric) {
            $rules[] = 'numeric';
        }

        return $rules;
    }
}
