<?php

namespace Informer\Proxy\Client;

class ImageProxy {

    public $width;
    public $height;
    public $source;

    function __construct($width, $height, $source) {
        $this->width = $width;
        $this->height = $height;
        $this->source = $source;
    }

}
