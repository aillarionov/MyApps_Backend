<?php

namespace Informer\Entities;

class Picture {

    private $images;

    function __construct($images) {
        $this->images = $images;
    }

    function getImages() {
        return $this->images;
    }

}
