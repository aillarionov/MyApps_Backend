<?php

namespace Informer\Proxy\Admin;

class OrgSimpleProxy {

    public $id;
    public $name;
    public $logo;
    public $code;

    function __construct($id, $name, $logo, $code) {
        $this->id = $id;
        $this->name = $name;
        $this->logo = $logo;
        $this->code = $code;
    }

}
