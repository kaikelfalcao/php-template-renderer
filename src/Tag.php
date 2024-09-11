<?php 

namespace Renderer;

class Tag {

    public static function string(string $template, array $data): string {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $template = str_replace("{{$key}}", $value, $template);
            }
        }
        return $template;
    }

    public static function array(string $template, array $data): string {
        return preg_replace_callback('/\{(\w+)\}(.*?)\{\/\1\}/s', function ($matches) use ($data) {
            $placeholder = $matches[1];
            $content = $matches[2];
            $items = $data[$placeholder] ?? [];

            if (!is_array($items)) {
                return $matches[0];
            }

            return self::processArrayItems($items, $content);
        }, $template);
    }

    private static function processArrayItems(array $items, string $content): string {
        $result = ' ';
        foreach ($items as $index => $item) {
            $itemContent = self::string($content, $item);
            $result .= ' ' . trim($itemContent);
            if ($index < count($items) - 1) {
                $result .= "\n ";
            }
        }
        return $result;
    }

    public static function optional(string $template, array $data): string {
        return preg_replace_callback('/\{\??(\w+)\}(.*?)\{\/\1\}/s', function ($matches) use ($data) {
            $placeholder = $matches[1];
            $content = $matches[2];
            if (isset($data[$placeholder]) && $data[$placeholder]) {
                return Tag::string($content, $data);
            }
            return '';
        }, $template);
    }
}