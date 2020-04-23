@if($column->sortable)
<a class="inline-flex items-center" role="button"
    wire:click.prevent="sortBy('{{ $column->orderBy ?? $column->attribute }}')" href="#">
    @include('tall-data-table::includes.sort-icon')
    {{ $column->text }}
</a>
@else
{{ $column->text }}
@endif