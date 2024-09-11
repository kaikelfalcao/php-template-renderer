<?php

namespace Renderer;

class Renderer {
    private $template;
    private $data;

    public function __construct(string $template, array $data) {
        $this->template = $template;
        $this->data = $data;
    }

    public function render() {
        $rendered = Tag::string($this->template, $this->data);
        $rendered = Tag::array($rendered, $this->data);
        $rendered = Tag::optional($rendered, $this->data);
        return trim($rendered);
    }
}