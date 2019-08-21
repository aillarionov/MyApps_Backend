<?php

namespace Informer\Proxy\Admin;

class FormProxy {

    public $id;
    public $name;
    public $dataEmail;
    public $items;
    
    function __construct($id, $name, $dataEmail, $items) {
        $this->id = $id;
        $this->name = $name;
        $this->dataEmail = $dataEmail;
        $this->items = $items;
    }

}
