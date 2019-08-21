<?php

namespace Informer\Proxy\Client;

class TicketProxy {

    public $type;
    public $source;
    public $text;
    public $button;

    function __construct($type, $source, $text, $button) {
        $this->type = $type;
        $this->source = $source;
        $this->text = $text;
        $this->button = $button;
    }


}
