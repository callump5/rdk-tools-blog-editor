<?php

namespace RdkTools\BlogEditor\Livewire\Elements;

use RdkTools\BlogEditor\Contracts\EditorComponent;
use RdkTools\BlogEditor\Traits\EditorElement;

class ImageElement extends EditorComponent
{
    use EditorElement;

    public string $slug = 'image-element';

    public function validateElement(string $data): array
    {
        return [];
    }
}
