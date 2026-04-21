<x-blog-editor::element-container :element="$element" elementKey="{{ $elementKey }}">
    <x-slot:title>Text Block</x-slot:title>
    <x-slot:editor-content>
        test
    </x-slot:editor-content>

    <x-slot:display-content>
        <img src="{{ asset('vendor/blog-editor/images/placeholder.png') }}" alt="Placeholder">
    </x-slot:display-content>

</x-blog-editor::element-container>
