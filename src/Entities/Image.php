<?php

namespace Informer\Entities;

class Image {

    private $width;
    private $height;
    private $source;

    function __construct($width, $height, $source) {
        $this->width = $width;
        $this->height = $height;
        $this->source = $source;
    }

    function getWidth() {
        return $this->width;
    }

    function getHeight() {
        return $this->height;
    }

    function getSource() {
        return $this->source;
    }

}
