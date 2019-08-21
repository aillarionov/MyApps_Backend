<?php

namespace Informer\Proxy\Client;

use stdClass;

class MenuItemProxy {
    
    public $id;
    public $type;
    public $name;
    public $icon;
    public $params;
    public $order;

    function __construct($id, $type, $name, $icon, $params, $order) {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->icon = $icon;
        $this->params = $params ? $params : new stdClass();
        $this->order = $order;
    }

}
