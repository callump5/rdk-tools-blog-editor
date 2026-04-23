<?php

namespace RdkTools\BlogEditor\Traits;

trait EditorElement
{
    public int|null $elementKey = null;
    public array $element = [];

    #[\Livewire\Attributes\On('contentUpdated')]
    public function contentUpdated(int $key, string $value)
    {
        if ($key !== $this->elementKey) {
            return;
        }

        $this->element['value'] = static::validateElement($value);
        $this->dispatch('updatedElement', $this->elementKey, $this->element);
    }

    public function updated($key, $vale)
    {
        $this->dispatch('updatedElement', $this->elementKey, $this->element);
    }

    public function editBlock()
    {
        $this->element['editing'] = true;
    }

    public function finishEditing()
    {
        $this->element['editing'] = false;
    }

    public function deleteElement($key)
    {
        $this->dispatch('deleteElementDataItem', $key);
    }

    public function render()
    {
        if (!isset($this->slug)) {
            throw new \Exception('Element slug has not been set!');
        }

        return view('blog-editor::livewire.elements.' . $this->slug);
    }
}
