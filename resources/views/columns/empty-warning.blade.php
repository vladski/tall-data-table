@if( empty($model->{$column->attribute}) )
<span @if($column->tooltip)data-tippy-content="{{ $column->tooltip }}"@endif>
    @svg('light/exclamation-triangle', "td-icon {$column->iconEmptyWarningColor}")
</span>
@endif