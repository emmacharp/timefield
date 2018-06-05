<?php

/**
 * @package toolkit
 */
/**
 * Specialized EntryQueryFieldAdapter that facilitate creation of queries filtering/sorting data from
 * a time Field.
 * @see FieldTime
 * @since Symphony 3.0.0
 */
class EntryQueryTimeAdapter extends EntryQueryFieldAdapter
{
    public function isFilterBetween($filter)
    {
        return preg_match('/\b ?to ?\b/i', $filter);
    }

    public function createFilterBetween($filter, array $columns)
    {
        $field_id = General::intval($this->field->get('id'));
        $filter = $this->field->cleanValue($filter);
        $matches = [];
        list($from, $to) = preg_split('/\b ?to ?\b/i', $filter);

        $from = trim($from);
        $to = trim($to);

        $from_sec = $this->field::timeStringToInt($from);
        $to_sec = $this->field::timeStringToInt($to);

        $conditions = [];
        foreach ($columns as $key => $col) {
            $conditions[] = [$this->formatColumn($col, $field_id) => ['between' => [$from_sec, $to_sec]]];
        }
        if (count($conditions) < 2) {
            return $conditions;
        }
        return ['or' => $conditions];
    }

    /**
     * @see EntryQueryFieldAdapter::filterSingle()
     *
     * @param EntryQuery $query
     * @param string $filter
     * @return array
     */
    protected function filterSingle(EntryQuery $query, $filter)
    {
        General::ensureType([
            'filter' => ['var' => $filter, 'type' => 'string'],
        ]);

        if ($this->isFilterBetween($filter)) {
            return $this->createFilterBetween($filter, $this->getFilterColumns());
        }
        return $this->createFilterEquality($filter, ['seconds']);
    }

    public function getSortColumns()
    {
        return ['seconds'];
    }
}
