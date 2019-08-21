<?php

namespace Informer\Proxy\Admin;

class CatalogProxy {

    public $id;
    public $type;
    public $visitorVisible;
    public $presenterVisible;
    public $source;
    public $sourceOwner;
    public $sourceAlbum;
    public $visitorNotificationFilter;
    public $presenterNotificationFilter;
    public $params;

    function __construct($id, $type, $visitorVisible, $presenterVisible, $source, $sourceOwner, $sourceAlbum, $visitorNotificationFilter, $presenterNotificationFilter, $params) {
        $this->id = $id;
        $this->type = $type;
        $this->visitorVisible = $visitorVisible;
        $this->presenterVisible = $presenterVisible;
        $this->source = $source;
        $this->sourceOwner = $sourceOwner;
        $this->sourceAlbum = $sourceAlbum;
        $this->visitorNotificationFilter = $visitorNotificationFilter;
        $this->presenterNotificationFilter = $presenterNotificationFilter;
        $this->params = $params;
    }


}
