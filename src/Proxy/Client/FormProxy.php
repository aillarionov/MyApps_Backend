<?php

namespace Informer\Proxy\Client;

class FormProxy {

    public $id;
    public $name;
    public $items;
    
    function __construct($id, $name, $items) {
        $this->id = $id;
        $this->name = $name;
        $this->items = $items;
    }

}
