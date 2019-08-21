<?php

namespace Informer\Proxy\Admin;

class CityProxy {

    public $id;
    public $name;

    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

}
