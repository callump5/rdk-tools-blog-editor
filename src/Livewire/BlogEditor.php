<?php

namespace RdkTools\BlogEditor\Livewire;

use Livewire\Component;

/*
*   References:
*   https://developer.mozilla.org/en-US/docs/Web/API/Document/execCommand
*/

class BlogEditor extends Component
{

    public array $elementOptions = [];
    public array $elementData = [];

    public function mount()
    {
        $this->registerElements();
    }

    #[\Livewire\Attributes\On('updatedElement')]
    public function updatedElement($key, $element)
    {
        $this->elementData[$key] = $element;
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

    public function addElement(string $element)
    {
        $this->elementData[] = $this->elementOptions[$element];
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
