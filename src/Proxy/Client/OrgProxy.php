<?php

namespace Informer\Proxy\Client;

class OrgProxy {

    public $id;
    public $name;
    public $logo;
    public $code;
    public $menuItems;
    public $forms;
    public $catalogs;
    public $ticket;
    public $city;

    function __construct($id, $name, $logo, $code, $menuItems, $forms, $catalogs, $ticket, $city) {
        $this->id = $id;
        $this->name = $name;
        $this->logo = $logo;
        $this->code = $code;
        $this->menuItems = $menuItems;
        $this->forms = $forms;
        $this->catalogs = $catalogs;
        $this->ticket = $ticket;
        $this->city = $city;
    }

}
