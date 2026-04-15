<?php

namespace RdkTools\BlogEditor\Elements;

use HTMLPurifier;
use HTMLPurifier_Config;

class TextElement
{

    public static function parseElementContent(string $rawHtml): string
    {
        $cleaned = self::cleanHtml($rawHtml);
        $wrapped = self::formatUnwrapped($cleaned);
        $styled = self::addStyles($wrapped);
        return $styled;
    }
    public static function formatUnwrapped(string $cleanHtml): string
    {
        $dom = new \DOMDocument();

        if (!$cleanHtml) {
            return '';
        }

        @$dom->loadHTML($cleanHtml);


        $nodesToProcess = [];
        foreach ($dom->getElementsByTagName('body')->item(0)->childNodes as $node) {
            if ($node->nodeType === XML_TEXT_NODE) {
                $text = trim($node->textContent);
                if (!empty($text)) {
                    $nodesToProcess[] = $node;
                }
            }
        }

        foreach ($nodesToProcess as $node) {
            $text = trim($node->textContent);

            // Create new p element
            $p = $dom->createElement('p');
            $p->appendChild($dom->createTextNode($text));

            // Replace text node with p element
            $node->parentNode->replaceChild($p, $node);
        }

        return $dom->saveHTML();
    }


    public static function addStyles(string $cleanHtml, array $styles = []): string
    {
        $defaultStyles = [
            'p' => 'font-size: 16px; line-height: 1.6; margin: 10px 0;',
            'h1' => 'text-white uppercase text-xl font-bold mb-5',
            'h2' => 'font-size: 28px; margin: 18px 0; font-weight: bold;',
            'a' => 'color: #0066cc; text-decoration: underline;',
            'strong' => 'font-weight: bold;',
            'em' => 'font-style: italic;',
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
                $existing = $element->getAttribute('class');
                $element->setAttribute('class', $existing . $style);
            }
        }

        return $dom->saveHTML();
    }

    private static function cleanHtml(string $data): string
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,br,strong,em,u,h1,h2,h3,a,img,blockquote,ul,li');
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

    public static function renderFormField($key, $element)
    {
        $data = self::parseElementContent($element['value'] ?? '');

        return view('blog-editor::components.form-field', [
            'key' => $key,
            'data' => $data,
        ])->render();
    }


    public function renderContent(array $data): string
    {
        return "";
    }
}
