<?php

namespace Informer\Proxy\Client;

class CatalogImageProxy {

    public $id;
    public $date;
    public $pictures;

    function __construct($id, $date, $pictures) {
        $this->id = $id;
        $this->date = $date;
        $this->pictures = $pictures;
    }
  
}
