<?php

namespace RdkTools\BlogEditor\Livewire;

use Livewire\Component;
use RdkTools\BlogEditor\Elements\TextElement;

class BlogEditor extends Component
{

    public array $elementOptions = [];
    public array $elementData = [];

    public function mount()
    {
        $this->registerElements();
    }

    public function registerElements()
    {
        $this->elementOptions['text'] = [
            'label' => 'Text',
        ];
    }

    public function addElement(string $element)
    {
        $this->elementData[] = $this->elementOptions[$element];
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
