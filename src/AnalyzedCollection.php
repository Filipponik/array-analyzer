<?php

declare(strict_types=1);

namespace Filipponik\ArrayAnalyzer;

class AnalyzedCollection
{
    /** @var array<int, AnalyzeField> */
    private array $fields = [];

    private AnalyzedCollectionFormatter $formatter;

    public function __construct(AnalyzedCollectionFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function pushFieldIfNotPresented(AnalyzeField $field): void
    {
        if (!$this->findFieldByName($field->getName())) {
            $this->pushField($field);
        }
    }

    public function findFieldByName(string $name): ?AnalyzeField
    {
        return $this->fields[$name] ?? null;
    }

    public function pushField(AnalyzeField $field): void
    {
        $this->fields[$field->getName()] = $field;
    }

    public function toArray(): array
    {
        return $this->format()->toArray();
    }

    public function toJson(): string
    {
        return $this->format()->toJson();
    }

    private function format(): AnalyzedCollectionFormatter
    {
        return $this->formatter->setFields($this->fields);
    }
}
