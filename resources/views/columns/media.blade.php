{{-- MEDIA get spatie media --}}
@php $url = $model->getFirstMediaUrl($column->mediaCollection) @endphp
<div class="mx-auto bg-contain bg-no-repeat bg-center h-12 w-12 {{ $column->mediaClass }} {{ filled($url) ? null : 'bg-gray-200' }}"
    style="background-image: url('{{ $url }}')"></div>