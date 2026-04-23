<?php

namespace RdkTools\BlogEditor\Livewire;

use Livewire\Component;

class FrontendContent extends Component
{
    public array $contentData;

    public function mount(string $data)
    {
        $this->contentData = json_decode($data, true);
    }

    public function render()
    {
        return view('blog-editor::livewire.frontend-content');
    }
}
