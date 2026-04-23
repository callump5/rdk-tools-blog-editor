<x-blog-editor::element-container :element="$element" elementKey="{{ $elementKey }}">
    <x-slot:title>Single Image</x-slot:title>
    <x-slot:editor-content>
        <div class="p-2.5">



            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-2">
                    @isset($element['upload_path'])
                        <img src="{{ asset($element['upload_path']) }}" alt="">
                    @elseif(isset($element['src']))
                        <img src="{{ asset($element['src']) }}" alt="">
                    @else
                        <img src="{{ asset('vendor/blog-editor/images/placeholder.png') }}" alt="">
                    @endisset
                </div>

                <div class="p-2 col-span-2 flex flex-col justify-center">
                    <div class="mb-7">
                        <span class="block uppercase font mb-4">Upload Image</span>
                        <input class="block mb-1 text-xs uppercase" wire:model.live='element.value' type="file"
                            name="" id="">
                        <div wire:loading wire:target="element.value">Uploading...</div>
                    </div>

                    <div class="mb-3">
                        <span class="block text-xs uppercase font mb-1">Alt Tag</span>
                        <input type="text" wire:model.live='element.options.alt_tag'
                            class='block w-full rounded-lg border-0 border-gray-300 bg-black/30 p-2.5 text-sm focus:border-blue-500 focus:ring-blue-500'>
                    </div>
                    <div class="flex gap-3">

                        <div class="mb-3">
                            <span class="block text-xs uppercase font mb-1">Max Width</span>
                            <input type="text" wire:model.live='element.options.max_width'
                                class='block w-full rounded-lg border-0 border-gray-300 bg-black/30 p-2.5 text-sm focus:border-blue-500 focus:ring-blue-500'>
                        </div>

                        <div class="mb-3">
                            <span class="block text-xs uppercase font mb-1">Margin</span>
                            <input type="text" wire:model.live='element.options.margin'
                                class='block w-full rounded-lg border-0 border-gray-300 bg-black/30 p-2.5 text-sm focus:border-blue-500 focus:ring-blue-500'>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </x-slot:editor-content>

    <x-slot:display-content>
        @isset($element['upload_path'])
            <img src="{{ asset($element['upload_path']) }}" alt="1">
        @elseif(isset($element['src']))
            <img src="{{ asset($element['src']) }}" alt="2">
        @else
            <img src="{{ asset('vendor/blog-editor/images/placeholder.png') }}" alt="">
        @endisset
    </x-slot:display-content>
</x-blog-editor::element-container>
