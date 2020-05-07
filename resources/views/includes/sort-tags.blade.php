{{-- Sort tags for small screens --}}
{{-- kept styling for larger screens if we want to bring it back --}}
<div class="flex items-center mt-4 sm:mt-0 {{ $visibleSortTags == true ?: 'md:hidden' }}">
    <span class="text-xs pr-2">@lang('fields.sort')</span>
    @foreach($groups as $group)
    @foreach ($group as $column)
        @if ($column->isSortable())
            <a href="#" role="button" wire:click.prevent="sortBy('{{ $column->orderBy ?? $column->attribute }}')"
               class="inline-flex items-center mx-1 px-2 py-0.5 rounded text-xs font-medium leading-4 bg-indigo-100 text-indigo-800">
                @include('tall-data-table::includes.sort-icon')
                {{ $column->text }}
            </a>
        @endif
    @endforeach
    @endforeach
</div>