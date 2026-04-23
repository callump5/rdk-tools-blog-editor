<?php

namespace RdkTools\BlogEditor\Traits;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use RdkTools\BlogEditor\Livewire\Elements\TextElement;

trait HasBlogEditor
{
    public array $blogEditorContent = [];

    #[\Livewire\Attributes\On('updatedEditorContent')]
    public function updatedEditorContent(array $data)
    {
        $this->blogEditorContent = $data;
    }


    public function saveBlogEditorContent(object $object, $save = true)
    {
        foreach ($this->blogEditorContent as $key => $element) {
            $element['editing'] = false;

            if ($element['slug'] === 'text-element') {
                $element['value'] = TextElement::validateElement($element['value']);
            }

            if ($element['slug'] === 'image-element') {

                if (isset($element['path'])) {

                    if (str_contains($element['src'], 'editor-images') !== false && isset($element['upload_path'])) {
                        $this->blogEditorContent[$key] = $element;
                        continue;
                    }
                    $tmpImage = TemporaryUploadedFile::unserializeFromLivewireRequest('livewire-file:' . $element['path']);
                    $path = $tmpImage->store('editor-images');
                    $element['upload_path'] = $path;
                    $element['src'] = $path;
                }
            }

            $this->blogEditorContent[$key] = $element;
        }


        try {

            $object->blog_editor_content = json_encode($this->blogEditorContent);

            if ($save) {
                $object->save();
            }
        } catch (\Exception $e) {
            throw new \Exception('Unable to save, make sure you have published the vendor assets and ran the migration!');
        }
    }
}
