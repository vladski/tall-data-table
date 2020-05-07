@foreach($model->tags as $tag)
<span class="{{$column->tagClass ?? 'bg-indigo-100 text-indigo-800'}} inline-flex items-center px-2 py-0.5 rounded text-xs font-medium leading-4">
    {{ $tag->name }}
</span>
@endforeach