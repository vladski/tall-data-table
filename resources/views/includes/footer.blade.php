@if ($tableFooterEnabled)
    <div class="{{ $tableFooterClass }}">
        @include('tall-data-table::includes.th')
    </div>
@endif