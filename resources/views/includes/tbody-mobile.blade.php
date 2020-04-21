<tr x-on:click="window.location.href='{{route("app.{$modelName}s.show", [$modelName => $model->{$model->getRouteKeyName()}])}}'"
class="sm:hidden cursor-pointer {{ $trClass }}" 
wire:key="{{ $model->{$model->getRouteKeyName()} }}">
    {{-- left checkbox --}}
    @if($checkbox && $checkboxLocation === 'left')
        @include('tall-data-table::includes.checkbox-row')
    @endif
    
    {{-- start td --}}
    <td class="{{$tdClass}}">
        @if($grouped)
            {{-- grouped cell --}}
            <table class="w-full">
                @foreach($groups as $group)
                <tr class="tr">
                    @foreach ($group as $column)
                        <td class="{{ $column->colClass }} {{ $column->visibility }} {{ $column->align }}">
                            @include('tall-data-table::includes.td-mobile-content')
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </table>
        @else
            {{-- single cell --}}
            @foreach($groups as $group)
            @foreach ($group as $column)
                <div class="w-full flex flex-inline {{ $column->colClass }} {{ $column->visibility }} {{ $column->align }}">
                    @include('tall-data-table::includes.td-mobile-content')
                </div>
            @endforeach
            @endforeach
        @endif
    </td>

    {{-- right checkbox --}}
    @if($checkbox && $checkboxLocation === 'right')
        @include('tall-data-table::includes.checkbox-row')
    @endif

    {{-- arrow --}}
    @if($arrow)
        @include('tall-data-table::includes.right-arrow')
    @endif
</tr>