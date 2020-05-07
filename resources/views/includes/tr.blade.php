{{-- left checkbox --}}
@if($checkbox)
<div wire:click.stop class="tablet:hidden md:table-cell align-middle px-4 border-b border-gray-200" style="width: 1%;">
@include('tall-data-table::includes.checkbox-row')
</div>
@endif

@foreach($groups as $group)
    @if(count($groups) > 1)
        <div class="md:py-4 grid-cols-{{count($group)}} {{ $groupClass }}" dusk="td-group-wrapper">
            @foreach($group as $column)
                @if (!$column->isHidden())
        <div class="{{ $groupedTdClass }} {{ $column->visibility }} col-span-{{ $column->colspan }}" dusk="groupded-td">
                    <div class="md:hidden {{ $column->labelClass }} {{ $column->labelWidth }}" dusk="groupded-td-label">{{ $column->text }}</div>
                    <div class="tablet:py-2 flex-1 md:block {{ $column->align }} {{ $column->colClass}} {{ $column->visibility }}" dusk="grouped-td-value">@include('tall-data-table::includes.cell')</div>
                </div>
                @endif
            @endforeach
        </div>
    @else
        @foreach($group as $column)
            @if (!$column->isHidden())
            <div class="md:py-4 {{ $tdClass }} col-span-{{ $column->colspan }} {{ $column->align }} {{ $column->colClass}}{{ $column->visibility }}" dusk="td">
                <div class="md:hidden {{ $column->labelClass }} {{ $column->labelWidth }}" dusk="td-label">{{ $column->text }}</div>
                <div class="tablet:py-2 flex-1 md:block" dusk="td-value">@include('tall-data-table::includes.cell')</div>
            </div>
            @endif
        @endforeach
    @endif
@endforeach

{{-- arrow or right checkbox --}}
@if($arrow || $checkbox)
<div class="absolute align-middle border-gray-200 first:pl-4 flex flex-col h-full justify-evenly lg:first:pl-6 lg:last:pr-6 md:border-b md:last:pr-4 md:relative md:right-0 md:table-cell right-4 text-center top-0 whitespace-normal">
    @if($checkbox)
    <div wire:click.stop class="flex items-center md:hidden" style="width: 1%;">
        @include('tall-data-table::includes.checkbox-row')
    </div>
    @endif
    <div class="flex items-center md:block text-right">
        {{-- right checkbox --}}
        @if($hasRowPanel)
            @if($selectedID == $model->uuid)
                @svg('light/chevron-down', 'ml-auto h-5 w-5 text-gray-400')
            @else
                @svg('light/chevron-right', 'ml-auto h-5 w-5 text-gray-400')
            @endif
        @else
            @svg('light/chevron-right', 'ml-auto h-5 w-5 text-gray-400')
        @endif
    </div>
</div>
@endif