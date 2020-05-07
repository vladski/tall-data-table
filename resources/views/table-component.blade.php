<div class="display-contents">
    @if (is_numeric($refresh))
    <div class="flex flex-col h-screen justify-between" wire:poll.{{ $refresh }}.ms>
        @elseif (is_string($refresh))
        <div class="flex flex-col h-screen justify-between" wire:poll="{{ $refresh }}">
            @else
            <div class="flex flex-col h-screen justify-between">
                @endif

                {{-- search field --}}
                @include('tall-data-table::includes.search')
                @include('tall-data-table::includes.offline')
                @if ($searchEnabled && $loadingIndicator)
                    @include('tall-data-table::includes.loading', ['target' => 'search'])
                @endif

                {{-- Main section --}}
                <main x-data="{ modal: false, sidePanel: false }"
                    class="flex-1 relative z-0 overflow-y-auto py-6 focus:outline-none" tabindex="0">
                    <div class="sm:flex sm:items-center mx-auto px-4 sm:px-6 lg:px-8">

                        {{-- Title --}}
                        <h1 class="text-2xl font-semibold mr-auto text-gray-900">
                            {{ $title }} @if($createButton)
                            <span class="cursor-pointer"
                                x-on:click="window.location.href = '{{ route("app.{$routePath}.create") }}'">
                                @svg('light/plus-circle', 'w-7 h-7 ml-3 text-gray-600 inline-flex')
                            </span>
                            @endif
                        </h1>

                        {{-- sort tags and perPage select --}}
                        @if($models->isNotEmpty())
                        @include('tall-data-table::includes.sort-tags')
                        @include('tall-data-table::includes.per-page-select')
                        @endif
                    </div>

                    {{-- after title slot --}}
                    @if(isset($afterTitle))
                    <div class="mx-auto px-4 py-4 sm:px-6 lg:px-8">
                        @include($afterTitle)
                    </div>
                    @endif

                    {{-- Table --}}
                    <div class="mx-auto mt-2 px-4 sm:px-6 lg:px-8">
                        <div class="flex flex-col md:flex-row py-2">
                            @if(isset($sidePanel))
                            <div class="bg-white border w-full lg:w-1/4 md:w-1/3 rounded shadow">
                                @include($sidePanel)
                            </div>
                            @endif
                            @if(isset($noTable))
                            <div class="w-full">
                                @else
                                <div
                                    class="align-middle inline-block w-full md:border-b md:border-gray-200 md:rounded-lg md:shadow overflow-hidden">
                                    @endif
                                    {{-- no items found --}}
                                    @if($models->isEmpty())
                                    <div class="w-full h-12 px-8 bg-white flex items-center">
                                        @svg('light/sad-tear', 'w-5 h-5 mr-2') {{ $noResultsMessage }} {{$title}}
                                    </div>
                                    @else
                                    @if(isset($noTable)) @include($noTable) @else
                                    <div class="{{ $tableClass }}" dusk="table">
                                        @include('tall-data-table::includes.header')
                                        @include('tall-data-table::includes.body')
                                        @include('tall-data-table::includes.footer')
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($hasRowPanel)
                        <div x-show="sidePanel" x-cloak x-on:click.stop="sidePanel = false"
                            style="position: fixed; top: 62px; right: 0; bottom: 63px;"
                            class="z-10 w-11/12 sm:w-10/12 md:w-2/3 lg:w-2/3 xl:w-1/2 overflow-scroll cursor-pointer bg-white border hover:bg-gray-100">
                            {{-- <div class="table-cell" colspan="{{ count(array_dot($groups), COUNT_RECURSIVE) }}">
                            --}}
                            @livewire($rowPanel)
                            {{-- </div> --}}
                            <div x-on:click.stop="sidePanel = false" class="absolute h-6 hover:bg-night-light hover:text-white left-2 overflow-visible rounded-full text-center text-gray-400 top-2 w-6">
                                @svg('light/times', 'h-5 w-5')
                            </div>
                        </div>
                        @endif
                        {{-- modal slot --}}
                        @if(isset($modal)) @include($modal) @endif
                        {{-- side panel --}}
                </main>
                {{-- Footer Pagination --}}
                @include('tall-data-table::includes.pagination')
            </div>
            @push('scripts')
            <script>
            document.addEventListener('turbolinks:load', function () {
                document.title = '{{ $title }}'
            })
            </script>
            @endpush
        </div>