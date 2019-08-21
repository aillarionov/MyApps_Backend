<?php

namespace Informer\Proxy\Admin;

use stdClass;

class MenuItemProxy {
    
    public $id;
    public $type;
    public $name;
    public $icon;
    public $form;
    public $catalog;
    public $params;
    public $order;

    function __construct($id, $type, $name, $icon, $form, $catalog, $params, $order) {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->icon = $icon;
        $this->form = $form;
        $this->catalog = $catalog;
        $this->params = $params ? $params : new stdClass();
        $this->order = $order;
    }

}
