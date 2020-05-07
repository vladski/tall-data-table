<div class="{{ $theadTrClass }}" dusk="th-tr">
@if(isset($customHead))
    {{-- custom thead replaces fields loop --}}
    @include($customHead)
@else
    {{-- checkbox --}}
    @if($checkbox)
    <div wire:click.stop dusk="checkbox-all" class="leading-4 px-4 py-3 table-cell">
        <input type="checkbox" wire:model="checkboxAll" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
    </div>
    @endif
    {{-- loop --}}
    @if(count($groups) > 1)
        @foreach ($groups as $group)
        <div dusk="th" class="{{ $thClass }}">
                @foreach ($group as $column)
                    <div class="w-full {{ $column->align }} {{ $column->visibility }}">
                        @include('tall-data-table::includes.th-link')
                    </div> 
                @endforeach
            </div>
        @endforeach
    @else
        @foreach($groups as $group)
            @foreach ($group as $column)
                <div dusk="th" class="{{ $thClass }} {{ $column->align }} {{ $column->visibility }}">
                    @include('tall-data-table::includes.th-link')
                </div>
            @endforeach
        @endforeach
    @endif
    {{-- extra slot for additional th after loop --}}
    @if(isset($theadSlot))
     @include($theadSlot)
    @endif
    {{-- empty div for arrow --}}
    @if($arrow)
        <div class="{{ $thClass }}"></div>
    @endif
@endif
</div>
