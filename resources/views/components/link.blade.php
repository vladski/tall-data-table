@php
$href = array_get($attributes, 'href', null);
if(is_callable($href)) {
$href = app()->call($href, ['model' => $model]);
}
@endphp
{{-- only show link if it exists --}}
@if(filled($href))
<a href="{{ $href }}" @foreach ($attributes as $key=> $value)
    @if ($key != 'href')
    {{ $key }}="{{ $value }}"
    @endif
    @endforeach
    >
    @if (array_key_exists('icon', $options))
    @svg($options['icon'], 'w-3 h-3 mr-0.5')
    @endif
    {{ $options['text'] ?? '' }}
</a>
@endif