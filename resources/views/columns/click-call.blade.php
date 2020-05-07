<a href="tel:'{{  ($column->callfield ?? $model->{$column->attribute}) }}'">
    {{ $model->{$column->attribute} }}
</a>