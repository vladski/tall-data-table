@php
    if(is_callable($column->displayAttribute)) {
        echo app()->call($column->displayAttribute, ['model' => $model]);
    } else {
    echo $model->{$column->attribute};
    }
@endphp