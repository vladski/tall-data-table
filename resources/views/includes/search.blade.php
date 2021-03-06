{{-- search field --}}
<x-layout.topbar>
    @if ($searchEnabled)
    <div class="w-full flex md:ml-0" data-tippy-content="{{ $this->searchTooltip() }}">
        <label for="search_field" class="sr-only">Search</label>
        <div class="relative w-full text-gray-400 focus-within:text-gray-600">
            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                @svg('light/search', 'ml-2 h-5 w-5')
            </div>
            <input 
            @if (is_numeric($searchDebounce)) wire:model.debounce.{{ $searchDebounce }}ms="search" @endif
            @if ($disableSearchOnLoading) wire:loading.attr="disabled" @endif
            id="search_field" 
            name="search_field" 
            class="block w-full h-full pl-8 pr-3 py-2 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 sm:text-sm"
            placeholder="{{ $searchLabel }}" type="search"/>
        </div>
    </div>
    @endif
</x-layout.topbar>

