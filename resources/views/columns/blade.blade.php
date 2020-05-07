@php
$php_html = Blade::compileString($column->bladeString);
    if(filled($php_html)) {
        echo eval(' ?>'.$php_html.'<?php '); 
    }
@endphp