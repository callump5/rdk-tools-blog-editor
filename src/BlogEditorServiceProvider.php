<?php


namespace RdkTools\BlogEditor;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class BlogEditorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'blog-editor');

        Livewire::addNamespace(
            namespace: 'blog-editor',
            classNamespace: 'RdkTools\\BlogEditor\\Livewire',
            classPath: __DIR__ . '/Livewire',
            classViewPath: __DIR__ . '/../resources/views/livewire',
        );

        $this->publishes([
            __DIR__ . '/../migrations' => database_path('migrations'),
            __DIR__ . '/../public' => public_path('vendor/blog-editor'),
        ], 'blog-editor-assets');
    }
}
