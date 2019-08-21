<?php

namespace Informer\Proxy\Admin;

class TicketProxy {

    public $id;
    public $type;
    public $source;
    public $text;
    public $button;

    function __construct($id, $type, $source, $text, $button) {
        $this->id = $id;
        $this->type = $type;
        $this->source = $source;
        $this->text = $text;
        $this->button = $button;
    }


}
