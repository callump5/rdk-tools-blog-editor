<div class='block-container  col-span-{{ $element['colspan'] ?? 4 }} row-span-{{ $element['rowspan'] ?? 1 }}'
    wire:wire:key="element-key--{{ $elementKey }}">

    <div class="border rounded">
        <div @class([
            'rdk-wysiwyg bg-white text-black',
            'hidden' => !isset($element['editing']) || $element['editing'] === false,
        ]) data-element-key='{{ $elementKey }}'>
            <div class="flex justify-between p-2 ">
                <span class="block mb-1 text-xs uppercase">{{ $title }}</span>
                <span class="text-xs block mb-4 uppercase" wire:click='finishEditing({{ $elementKey }})'>Close</span>
            </div>

            @isset($editorContent)
                {{ $editorContent }}
            @endisset
        </div>
        {{-- @else --}}
        <div @class([
            'rdk-text-element p-2 ',
            'hidden' => isset($element['editing']) && $element['editing'] === true,
        ]) data-element-key='{{ $elementKey }}'>

            <div class="flex justify-between border-b border-white/30 pb-2 mb-2">
                <div class="">

                    <span class="block mb-1 text-xs uppercase">{{ $element['label'] }}</span>

                    <div class="flex gap-2 justify-end ">
                        <span for="" class="text-[10px] block uppercase ">Cols</span>
                        <input wire:model.live='element.colspan'
                            class="bg-transparent p-0 text-xs max-w-5 border-l-0 border-r-0 border-t-0 border-b-1 border-b-white/30" />
                        <span for="" class="text-[10px] block uppercase ">Rows</span>
                        <input wire:model.live='element.rowspan'
                            class="bg-transparent p-0 text-xs max-w-5 border-l-0 border-r-0 border-t-0 border-b-1 border-b-white/30" />
                    </div>
                </div>

                <span class="text-xs block  uppercase ml-3 " wire:click='editBlock({{ $elementKey }})'>Edit</span>

            </div>
            @isset($displayContent)
                {{ $displayContent }}
            @endisset

        </div>
        {{-- @endif --}}
    </div>
</div>
