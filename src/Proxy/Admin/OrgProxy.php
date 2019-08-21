<?php

namespace Informer\Proxy\Admin;

class OrgProxy {

    public $id;
    public $name;
    public $logo;
    public $code;
    public $catalogs;
    public $menuItems;
    public $forms;
    public $ticket;
    public $city;
    public $suspend;

    function __construct($id, $name, $logo, $code, $catalogs, $menuItems, $forms, $ticket, $city, $suspend) {
        $this->id = $id;
        $this->name = $name;
        $this->logo = $logo;
        $this->code = $code;
        $this->catalogs = $catalogs;
        $this->menuItems = $menuItems;
        $this->forms = $forms;
        $this->ticket = $ticket;
        $this->city = $city;
        $this->suspend = $suspend;
    }

}
