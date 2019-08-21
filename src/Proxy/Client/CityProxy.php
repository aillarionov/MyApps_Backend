<?php

namespace Informer\Proxy\Client;

class CityProxy {

    public $id;
    public $name;

    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

}
