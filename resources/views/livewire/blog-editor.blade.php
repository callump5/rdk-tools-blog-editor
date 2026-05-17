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

        <main class="col-span-5 grid grid-cols-12 gap-4">
            @isset($elementData)
                @foreach ($elementData as $key => $element)
                    <div class='block-container  col-span-{{ $element['colspan'] ?? 4 }} row-span-{{ $element['rowspan'] ?? 1 }}'
                        wire:key="element-key--{{ $element['uuid'] ?? $key }}" data-loop-key="{{ $key }}">
                        <div class="flex gap-2 border border-b-0 rounded p-2">
                            <span class="text-xs block  uppercase cursor-pointer" wire:click='moveUp({{ $key }})'>
                                <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                            <span class="text-xs block  uppercase cursor-pointer"
                                wire:click='moveDown({{ $key }})'><svg class="w-4 h-4 text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4" />
                                </svg>
                            </span>

                        </div>
                        @if ($element['slug'] === 'text-element')
                            <livewire:blog-editor::elements.text-element elementKey="{{ $key }}"
                                :element="$element" />
                        @endif
                        @if ($element['slug'] === 'image-element')
                            <livewire:blog-editor::elements.image-element elementKey="{{ $key }}"
                                :element="$element" />
                        @endif
                    </div>
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


                        if (!iframe) return;
                        const doc = iframe.contentDocument || iframe.contentWindow.document;
                        const elementKey = i.dataset.elementKey;


                        // ADD THIS - Set UTF-8 encoding on iframe document
                        if (!doc.head.querySelector('meta[charset]')) {
                            const meta = doc.createElement('meta');
                            meta.charset = 'UTF-8';
                            doc.head.appendChild(meta);
                        }

                        doc.designMode = 'on';
                        doc.body.style.fontFamily = 'Arial';
                        doc.body.style.padding = '10px 0 ';
                        doc.body.style.height = '500px';

                        // Store doc by key
                        editors[elementKey] = doc;

                        let debounceTimer;

                        doc.addEventListener('input', (event) => {
                            clearTimeout(debounceTimer);
                            debounceTimer = setTimeout(() => {
                                $wire.$dispatch('contentUpdated', {
                                    key: elementKey,
                                    value: doc.body.innerHTML
                                })
                            }, 600); // 300ms delay
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
                        if (action === 'headingTertiary') doc.execCommand('formatBlock', false, '<h3>');
                        if (action === 'link') {
                            const url = prompt('URL:');
                            if (url) doc.execCommand('createLink', false, url);
                        }

                        doc.body.focus();
                    });
                }

                initaliseWysiwyg();

                $wire.$on('initaliseWysiwyg', function() {
                    initaliseWysiwyg();
                });
            </script>
        @endscript
    @endpush

</div>
