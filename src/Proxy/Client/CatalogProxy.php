<?php

namespace Informer\Proxy\Client;

class CatalogProxy {

    public $id;
    public $type;
    public $visitorVisible;
    public $presenterVisible;

    function __construct($id, $type, $visitorVisible, $presenterVisible) {
        $this->id = $id;
        $this->type = $type;
        $this->visitorVisible = $visitorVisible;
        $this->presenterVisible = $presenterVisible;
    }

}
