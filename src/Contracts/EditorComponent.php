<?php

namespace RdkTools\BlogEditor\Contracts;

use Livewire\Component;

abstract class EditorComponent extends Component
{
    abstract public function validateElement(string $data): string|array|int;
}
