<?php

namespace Informer\Proxy\Client;

use stdClass;

class FormItemProxy {

    public $id;
    public $type;
    public $name;
    public $title;
    public $required;
    public $params;
    public $order;

    function __construct($id, $type, $name, $title, $required, $params, $order) {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->title = $title;
        $this->required = $required;
        $this->params = $params ? $params : new stdClass();
        $this->order = $order;
    }

}
