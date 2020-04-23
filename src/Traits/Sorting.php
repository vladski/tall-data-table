<?php

namespace Tanthammar\TallDataTable\Traits;

/**
 * Trait Sorting.
 */
trait Sorting
{
    /**
     * Sorting.
     */

    /**
     * The initial field to be sorting by.
     *
     * @var string
     */
    public $sortField = 'id';

    /**
     * The initial direction to sort.
     *
     * @var bool
     */
    public $sortDirection = 'asc';

    /**
     * @param $attribute
     */
    public function sortBy($attribute): void
    {
        clock($attribute, $this->sortField);
        if ($this->sortField !== $attribute) {
            $this->sortDirection = 'asc';
            clock($this->sortDirection);
        } else {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        }

        $this->sortField = $attribute;
        clock($this->sortDirection);
    }
}
