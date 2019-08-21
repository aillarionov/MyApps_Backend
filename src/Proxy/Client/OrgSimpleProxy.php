<?php

namespace Informer\Proxy\Client;

class OrgSimpleProxy {

    public $id;
    public $name;
    public $logo;
    public $code;
    public $city;

    function __construct($id, $name, $logo, $code, $city) {
        $this->id = $id;
        $this->name = $name;
        $this->logo = $logo;
        $this->code = $code;
        $this->city = $city;
    }

}
