<?php

namespace Informer\Entities;

class Item {

    private $id;
    private $raw;
    private $date;
    private $pictures;
    private $source;

    function __construct($id, $raw, $date, $pictures, $source) {
        $this->id = $id;
        $this->raw = $raw;
        $this->date = $date;
        $this->pictures = $pictures;
        $this->source = $source;
    }

    function getId() {
        return $this->id;
    }

    function getRaw() {
        return $this->raw;
    }

    function getDate() {
        return $this->date;
    }

    function getPictures() {
        return $this->pictures;
    }

    function getSource() {
        return $this->source;
    }

}
