<?php

namespace Tanthammar\TallDataTable\Views\Contracts;

/**
 * Interface Table.
 */
interface TableContract
{
    public function query();
    public function columns();
    public function models();
    public function render();
}
