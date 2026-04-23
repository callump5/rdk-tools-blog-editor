<?php

namespace RdkTools\BlogEditor\Livewire\Elements;

use HTMLPurifier;
use HTMLPurifier_Config;
use RdkTools\BlogEditor\Contracts\EditorComponent;
use RdkTools\BlogEditor\Traits\EditorElement;

class TextElement extends EditorComponent
{
    use EditorElement;

    public string $slug = 'text-element';

    public static function validateElement(string $rawHtml): string
    {
        $cleaned = self::cleanHtml($rawHtml);
        $wrapped = self::formatUnwrapped($cleaned);
        $styled = self::addStyles($wrapped);
        $html = self::removeBrTags($styled);
        $cleanedHtml = self::extractElements($html);


        return $cleanedHtml;
    }

    public static function extractElements($html)
    {
        $dom = new \DOMDocument();

        if (!$html) {
            return '';
        }

        @$dom->loadHTML($html);

        // Use this:
        $bodyElements = $dom->getElementsByTagName('body');
        if ($bodyElements->length > 0) {
            $body = $bodyElements->item(0);

            // Get only the inner HTML of the body
            $html = '';
            foreach ($body->childNodes as $node) {
                $html .= $dom->saveHTML($node);
            }

            return $html;
        }

        return '';
    }

    public static function removeBrTags(string $html): string
    {
        return str_replace(['<br />', '<br>'], '', $html);
    }

    public static function formatUnwrapped(string $cleanHtml): string
    {
        $dom = new \DOMDocument();

        if (!$cleanHtml) {
            return '';
        }

        @$dom->loadHTML($cleanHtml);

        // 1. Replace all div tags with p tags
        $divElements = $dom->getElementsByTagName('div');

        // Iterate backwards to avoid index issues when removing
        while ($divElements->length > 0) {
            $div = $divElements->item(0);

            // Create new p element
            $p = $dom->createElement('p');

            // Copy all attributes from div to p
            foreach ($div->attributes as $attr) {
                $p->setAttribute($attr->name, $attr->value);
            }

            // Move all child nodes from div to p
            while ($div->firstChild) {
                $p->appendChild($div->firstChild);
            }

            // Replace div with p
            $div->parentNode->replaceChild($p, $div);
        }

        // 2. Wrap unwrapped text nodes in p tags
        $nodesToProcess = [];

        $bodyElements = $dom->getElementsByTagName('body');
        if ($bodyElements->length > 0) {
            foreach ($bodyElements->item(0)->childNodes as $node) {
                if ($node->nodeType === XML_TEXT_NODE) {
                    $text = trim($node->textContent);
                    if (!empty($text)) {
                        $nodesToProcess[] = $node;
                    }
                }
            }
        }

        foreach ($nodesToProcess as $node) {
            $text = trim($node->textContent);

            $p = $dom->createElement('p');
            $p->appendChild($dom->createTextNode($text));

            $node->parentNode->replaceChild($p, $node);
        }

        return $dom->saveHTML();
    }

    public static function addStyles(string $cleanHtml, array $styles = []): string
    {
        $defaultStyles = [
            'p' => 'text-neutral-400  leading-relaxed mb-5 text-white',
            'h1' => 'text-white uppercase font-bold text-2xl md:text-4xl lg:text-5xl mb-4 md:leading-tight',
            'h2' => 'text-white uppercase font-bold text-2xl md:text-3xl mb-3 mt-10',
            'h3' => 'text-white uppercase font-bold text-lg md:text-xl mb-3 mt-5',
            'ol' => 'text-white list-decimal pl-5 space-y-4 mb-4',
            'ul' => 'text-white list-disc pl-5 space-y-4 mb-4',
            'li' => '',
            'a' => 'text-accent uppercase  hover:underline',
            'strong' => ' text-accent',
            'b' => 'text-accent',
            'img' => 'w-full',
            'blockquote' => 'border-left: 4px solid #ddd; padding-left: 10px; margin-left: 0; color: #666;',
        ];

        $mergedStyles = array_merge($defaultStyles, $styles);

        $dom = new \DOMDocument();
        if (!$cleanHtml) {
            return '';
        }

        @$dom->loadHTML($cleanHtml);


        foreach ($mergedStyles as $tag => $style) {
            foreach ($dom->getElementsByTagName($tag) as $element) {
                $element->setAttribute('class', $style);
            }
        }

        return $dom->saveHTML();
    }

    private static function cleanHtml(string $data): string
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,strong,em,u,h1,h2,h3,a,img,blockquote,ul,li');
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true]);
        $config->set('HTML.AllowedAttributes', [
            'img.src' => true,
            'img.alt' => true,
            'img.title' => true,
            'img.width' => true,
            'img.height' => true,
            'a.href' => true,
            'a.title' => true,
            'a.target' => true,
        ]);

        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
        $config->set('Attr.AllowedFrameTargets', ['_blank', '_self']);

        $purifier = new HTMLPurifier($config);
        return $purifier->purify($data);
    }
}
