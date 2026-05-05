<?php

namespace RdkTools\BlogEditor\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Livewire;

/*
*   References:
*   https://developer.mozilla.org/en-US/docs/Web/API/Document/execCommand
*/

class BlogEditor extends Component
{

    public array $elementOptions = [];
    public array $elementData = [];

    public function mount(null|string $data = '')
    {
        if (!empty($data)) {
            $this->elementData = json_decode($data, true);
            $this->dispatch('updatedEditorContent', $this->elementData);
        }
        $this->registerElements();
    }

    #[\Livewire\Attributes\On('deleteElementDataItem')]
    public function deleteElementDataItem($key)
    {
        unset($this->elementData[$key]);
        $this->dispatch('updatedEditorContent', $this->elementData);
    }

    #[\Livewire\Attributes\On('updatedElement')]
    public function updatedElement($key, $element)
    {
        $this->elementData[$key] = $element;
        $this->dispatch('updatedEditorContent', $this->elementData);
    }

    public function registerElements()
    {
        $this->elementOptions['text'] = [
            'label' => 'Text Block',
            'slug' => 'text-element',
        ];

        $this->elementOptions['image'] = [
            'label' => 'Single Image',
            'slug' => 'image-element',

        ];
    }

    #[\Livewire\Attributes\On('moveDown')]
    public function moveDown(int $elementKey)
    {
        $element = $this->elementData[$elementKey];
        unset($this->elementData[$elementKey]);

        $elementData = array_values($this->elementData);
        array_splice($elementData, $elementKey + 1, 0, [$element]);
        $this->elementData = $elementData;
        $this->dispatch('updatedEditorContent', $this->elementData);
    }

    #[\Livewire\Attributes\On('moveUp')]
    public function moveUp(int $elementKey)
    {
        $element = $this->elementData[$elementKey];
        unset($this->elementData[$elementKey]);

        $elementData = array_values($this->elementData);
        array_splice($elementData, $elementKey - 1, 0, [$element]);

        $this->elementData = $elementData;
        $this->dispatch('updatedEditorContent', $this->elementData);
    }

    public function addElement(string $element)
    {
        $element = $this->elementOptions[$element];
        $element['uuid'] = (string) Str::uuid();
        $this->elementData[] = $element;

        $this->dispatch('initaliseWysiwyg');
    }

    public function debug()
    {
        dd($this->elementData);
    }

    public function render()
    {
        return view('blog-editor::livewire.blog-editor');
    }
}
