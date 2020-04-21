@if ($tableHeaderEnabled)
    <div class="{{ $tableHeaderClass }}" dusk="thead">
        @include('tall-data-table::includes.th')
    </div>
@endif