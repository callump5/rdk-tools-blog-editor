<x-blog-editor::element-container :element="$element" elementKey="{{ $elementKey }}">
    <x-slot:title>Text Block</x-slot:title>
    <x-slot:editor-content>

        <div class='border-b border-t'>
            <button class='p-2 border-r' data-action="paragraph">P</button>
            <button class='p-2 border-r' data-action="bold">B</button>
            <button class='p-2 border-r' data-action="heading">H1</button>
            <button class='p-2 border-r' data-action="headingSecondary">H2</button>
            <button class='p-2 border-r' data-action="image">Image</button>
            <button class='p-2 ' data-action="link">Link</button>
        </div>

        <textarea class="content hidden">
                {{ $element['value'] ?? 'Tempor cupidatat nulla aliquip commodo nulla dolore consequat do ipsum. Ad laboris ea pariatur.' }}
            </textarea>

        <iframe class="editor w-full ">Testing</iframe>
    </x-slot:editor-content>

    <x-slot:display-content>
        <div class="space-y-4 py-3">
            {!! $element['value'] ??
                'Tempor cupidatat nulla aliquip commodo nulla dolore consequat do ipsum. Ad laboris ea pariatur.' !!}
        </div>
    </x-slot:display-content>
</x-blog-editor::element-container>
