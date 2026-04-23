<div class="grid grid-cols-12" style="column-gap:20px">
    @isset($contentData)
        @foreach ($contentData as $element)
            <div class="col-span-12 md:col-span-{{ $element['colspan'] ?? 4 }} md:row-span-{{ $element['rowspan'] ?? 1 }} ">
                @if ($element['slug'] === 'text-element')
                    {!! $element['value'] !!}
                @endif

                @if ($element['slug'] === 'image-element' && isset($element['upload_path']))
                    <img class="w-full mb-5" src="{{ asset($element['upload_path']) }}" alt="1">
                @endif
            </div>
        @endforeach
    @endisset
</div>
