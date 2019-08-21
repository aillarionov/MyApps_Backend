<?php

namespace Informer\Proxy\Client;

class CatalogNewsProxy {

    public $id;
    public $text;
    public $date;
    public $pictures;
    public $raw;

    function __construct($id, $text, $date, $pictures, $raw) {
        $this->id = $id;
        $this->text = $text;
        $this->date = $date;
        $this->pictures = $pictures;
        $this->raw = $raw;
    }
  
}
