@if($column->iconBefore) @svg($column->iconBefore, 'td-icon'. $column->iconBeforeColor) @endif
@if($column->type == 'empty-warning' && empty($model->{$column->attribute}) )
<span @if($column->tooltip)data-tippy-content="{{ $column->tooltip }}"@endif>
    @svg('light/exclamation-triangle', 'td-icon '. $column->iconEmptyWarningColor)
</span>
@endif
@if($column->type=='media') @include('tall-data-table::components.media') @endif
@if($column->type=='tags') @include('tall-data-table::components.tags') @endif
@php
if(!$column->hideValue) {
    switch ($column->type) {
        case 'html':
            echo new \Illuminate\Support\HtmlString( $model->{$column->attribute} );
            break;

        case 'unescaped':
            echo $model->{$column->attribute};
            break;

        case 'display-attribute':
            if(is_callable($column->displayAttribute)) {
                echo app()->call($column->displayAttribute, ['model' => $model]);
            } else {
                echo $model->{$column->attribute};
            }
        break;            

        case 'blade':
            $php_html = Blade::compileString($column->bladeString);
            if(filled($php_html)) {
                 echo eval(' ?>'.$php_html.'<?php '); 
            }
            break;

        case 'click-call':
            echo '<a href="tel:' . ($column->callfield ?? $model->{$column->attribute}) . '">' . $model->{$column->attribute} . '</a>';
            break;

        case 'key-val':
            echo \Arr::get($model->{$column->attribute}, $column->key, null);
            break;
        
        case 'related':
            echo $model->{$column->relation}->{$column->relationAttribute};
            break;

        default:
            echo $model->{$column->attribute} ?? null;
            break;
    }
}
@endphp
@if($column->iconAfter) @svg($column->iconAfter, 'td-icon'. $column->iconAfterColor) @endif