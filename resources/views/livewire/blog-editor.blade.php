<div class="grid grid-cols-4">

    <aside>
        <header>
            <h2>Elements</h2>
        </header>

        @isset($elementOptions)
            @foreach ($elementOptions as $key => $element)
                <button wire:click='addElement("{{ $key }}")'>
                    {{ $element['label'] }}
                </button>
            @endforeach
        @endisset

        <button wire:click='debug'>debug</button>
    </aside>

    <main class="col-span-3">
        @isset($elementData)
            @foreach ($elementData as $key => $element)
                <label for="">{{ $element['label'] }}</label>
                {!! \RdkTools\BlogEditor\Elements\TextElement::renderFormField($key, $element) !!}
            @endforeach
        @endisset
    </main>

</div>
