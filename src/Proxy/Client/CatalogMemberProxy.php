<?php

namespace Informer\Proxy\Client;

class CatalogMemberProxy {

    // Item
    public $id;
    public $text;
    public $date;
    public $pictures;
    public $raw;

    // Member
    public $name;
    public $stand;
    
    public $categories;
    public $phones;
    public $emails;
    public $sites;
    public $vks;
    public $fbs;
    public $insts;
    
    
    function __construct($id, $text, $date, $pictures, $raw, $name, $stand, $categories, $phones, $emails, $sites, $vks, $fbs, $insts) {
        $this->id = $id;
        $this->text = $text;
        $this->date = $date;
        $this->pictures = $pictures;
        $this->raw = $raw;
        $this->stand = $stand;
        $this->name = $name;
        $this->categories = $categories;
        $this->phones = $phones;
        $this->emails = $emails;
        $this->sites = $sites;
        $this->vks = $vks;
        $this->fbs = $fbs;
        $this->insts = $insts;
    }

    
    
   
  
}
