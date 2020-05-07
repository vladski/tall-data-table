<div class="{{ $tbodyClass }}" dusk="tbody">
    @foreach ($models as $model)
        {{-- custom tbody --}}
        @if(isset($tbody)) @include($tbody) @else
            @if($hasRowPanel)
                <div 
                dusk="tr" 
                class="cursor-pointer {{ $trClass }} {{ $trGridCols }}" 
                wire:key="{{ $model->uuid }}"
                wire:click.stop="$emit('modelSelected', '{{ $model->uuid }}')"
                x-on:click="sidePanel = true">
            @else
                <div 
                dusk="tr" 
                x-on:click.stop="window.location.href='{{route("app.{$routePath}.show", [$model->routeKey => $model->{$model->getRouteKeyName()}])}}'"
                class="cursor-pointer {{ $trClass }} {{ $trGridCols }}" 
                wire:key="{{ $model->{$model->getRouteKeyName()} }}">
            @endif
                {{-- default view --}}
                @if(empty($tbodyDesktop) && empty($tbodyMobile))
                    @include('tall-data-table::includes.tr')

                {{-- custom desktop view --}}
                @elseif(filled($tbodyDesktop) && empty($tbodyMobile))
                        <span class="tablet:hidden md:display-contents">@include($tbodyDesktop)</span>
                        <span class="display-contents md:hidden">@include('tall-data-table::includes.tr')</span>

                {{-- custom mobile view --}}
                @elseif(empty($tbodyDesktop) && filled($tbodyMobile))
                    <span class="tablet:hidden md:display-contents">@include('tall-data-table::includes.tr')</span>
                    <span class="display-contents md:hidden">@include($tbodyMobile)</span>
                @endif
            </div>
        @endif
    @endforeach
</div>