<?php

declare(strict_types=1);

namespace Filipponik\ArrayAnalyzer;

use Illuminate\Support\Collection;

class AnalyzedCollection
{
    private Collection $fields;

    private AnalyzedCollectionFormatter $formatter;

    public function __construct(AnalyzedCollectionFormatter $formatter)
    {
        $this->formatter = $formatter;
        $this->fields = collect();
    }

    public function getFields(): Collection
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
        return $this->fields->get($name);
    }

    public function pushField(AnalyzeField $field): void
    {
        $this->fields->put($field->getName(), $field);
    }

    public function toArray(): array
    {
        return $this->format()->toArray();
    }

    private function format(): AnalyzedCollectionFormatter
    {
        return $this->formatter->setFields($this->fields);
    }

    public function toJson(): string
    {
        return $this->format()->toJson();
    }
}