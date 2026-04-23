<?php

namespace RdkTools\BlogEditor\Livewire\Elements;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use RdkTools\BlogEditor\Contracts\EditorComponent;
use RdkTools\BlogEditor\Traits\EditorElement;

class ImageElement extends EditorComponent
{
    use EditorElement, WithFileUploads;

    public string $slug = 'image-element';

    public function mount()
    {
        // dd($this->element);
    }
    public function updatedElementValue($image)
    {
        $this->element['src'] = $image->temporaryUrl();
        $this->element['path'] = $image->getFilename();
        $this->element['value'] = null;

        $this->dispatch('updatedElement', $this->elementKey, $this->element);
    }
    public static function validateElement(string $data): array
    {
        return [];
    }
}
