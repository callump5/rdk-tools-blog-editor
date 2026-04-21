@push('header-scripts')
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
@endpush

<div>

    <div class="grid grid-cols-6 gap-5">

        <aside>
            <header>
                <h2 class="text-white uppercase font-bold mb-2">Elements</h2>
            </header>


            @isset($elementOptions)
                @foreach ($elementOptions as $key => $element)
                    <button class='bg-white/30 p-2 mb-2 block w-full rounded uppercase text-xs'
                        wire:click='addElement("{{ $key }}")'>
                        {{ $element['label'] }}
                    </button>
                @endforeach
            @endisset

            <button wire:click='debug' class='bg-white/30 p-2 mb-2 block w-full rounded uppercase text-xs'>debug</button>
        </aside>

        <main class="col-span-5 grid grid-cols-4 gap-4">
            @isset($elementData)
                @foreach ($elementData as $key => $element)
                    @if ($element['slug'] === 'text-element')
                        <livewire:blog-editor::elements.text-element elementKey="{{ $key }}" :element="$element" />
                    @endif
                    @if ($element['slug'] === 'image-element')
                        <livewire:blog-editor::elements.image-element elementKey="{{ $key }}" :element="$element" />
                    @endif
                @endforeach
            @endisset



        </main>
    </div>

    {{-- <x-blog-editor::popup></x-blog-editor::popup> --}}


    @push('footer-scripts')
        <script src="{{ asset('vendor/rdk-tools/blog-editor/js/rdk-tools-wysiwyg-editor.js') }}"></script>

        @script
            <script>
                function initaliseWysiwyg() {
                    const editors = {}; // Store doc objects by key

                    document.querySelectorAll('.rdk-wysiwyg').forEach(function(i) {
                        if (i.classList.contains('active')) return;

                        const iframe = i.querySelector('iframe');
                        const doc = iframe.contentDocument || iframe.contentWindow.document;
                        const elementKey = i.dataset.elementKey;

                        doc.designMode = 'on';
                        doc.body.style.fontFamily = 'Arial';
                        doc.body.style.padding = '10px 0 ';

                        // Store doc by key
                        editors[elementKey] = doc;

                        doc.addEventListener('input', (event) => {
                            $wire.$dispatch('contentUpdated', {
                                key: elementKey,
                                value: doc.body.innerHTML
                            })
                        });

                        const initialContent = i.querySelector('.content').value;
                        doc.body.innerHTML = initialContent;
                        doc.body.focus();

                        i.classList.add('active');
                    });

                    // ADD LISTENER ONCE, outside the loop
                    document.addEventListener('click', (e) => {
                        const action = e.target.dataset.action;
                        if (!action) return;

                        // Find which editor this button belongs to
                        const editor = e.target.closest('.rdk-wysiwyg');
                        if (!editor) return;

                        const elementKey = editor.dataset.elementKey;
                        const doc = editors[elementKey];

                        // Execute on the correct editor only
                        if (action === 'bold') doc.execCommand('bold');
                        if (action === 'italic') doc.execCommand('italic');
                        if (action === 'underline') doc.execCommand('underline');
                        if (action === 'paragraph') doc.execCommand('insertParagraph');
                        if (action === 'image') {
                            const url = prompt('Image URL:');
                            doc.execCommand('insertImage', false, url);
                        }
                        if (action === 'heading') doc.execCommand('formatBlock', false, '<h1>');
                        if (action === 'headingSecondary') doc.execCommand('formatBlock', false, '<h2>');
                        if (action === 'link') {
                            const url = prompt('URL:');
                            if (url) doc.execCommand('createLink', false, url);
                        }

                        doc.body.focus();
                    });
                }


                $wire.$on('initaliseWysiwyg', function() {
                    initaliseWysiwyg();
                });
            </script>
        @endscript
    @endpush

</div>
