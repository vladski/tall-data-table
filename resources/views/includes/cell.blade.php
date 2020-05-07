@if ($column->hasComponents())
    @include('tall-data-table::includes.component')
@elseif ($column->isView())
    @include($column->view)
@else
@if($column->iconBefore) @svg($column->iconBefore, 'td-icon'. $column->iconBeforeColor) @endif
@include("tall-data-table::columns.{$column->type}")
@if($column->iconAfter) @svg($column->iconAfter, 'td-icon'. $column->iconAfterColor) @endif
@endif