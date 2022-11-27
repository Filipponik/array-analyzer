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

            $arr[] = $preparedArr;
        }

        return $arr;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function toHTML(): string
    {
        $html = '<table>';
        $html.= <<<EOF
<tr>
<th>Field</th>
<th>Possible types</th>
<th>Possible values</th>
<th>May not be presented</th>
</tr>
EOF;
        foreach ($this->fields as $field) {
            /** @var AnalyzeField $field */
            $html .= '<tr>';
            $html .= "<td>{$field->getName()}</td>";
            $html .= '<td>' . implode(',', $field->getPossibleTypes()) . '</td>';
            $html .= '<td>' . implode(',', $field->getPossibleValues()) . '</td>';
            $html .= "<td>{$field->isMaybeNotPresented()}</td>";
            $html .= '</tr>';
        }

        $html .= '</table>';

        return $html;
    }
}