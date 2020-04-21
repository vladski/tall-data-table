@if ($column->hasComponents())
    @include('tall-data-table::includes.component')
@elseif ($column->isView())
    @include($column->view)
@else
    @include('tall-data-table::includes.field')
@endif