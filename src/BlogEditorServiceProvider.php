<?php


namespace RdkTools\BlogEditor;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class BlogEditorServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        // OR register with class path
        Livewire::addNamespace(
            namespace: 'blog-editor',
            classNamespace: 'RdkTools\\BlogEditor\\Livewire',
            classPath: __DIR__ . '/Livewire',
            classViewPath: __DIR__ . '/../resources/views/livewire',
        );
    }
}
