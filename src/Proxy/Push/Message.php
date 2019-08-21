<?php

namespace Informer\Proxy\Push;

use Informer\Enums\OSType;

class Message {

    private $text;
    private $data;
    private $osType;
    private $tokens;

    function __construct($text, $data, OSType $osType, $tokens) {
        $this->text = $text;
        $this->data = $data;
        $this->osType = $osType;
        $this->tokens = $tokens;
    }

    function getText() {
        return $this->text;
    }

    function getData() {
        return $this->data;
    }

    function getOsType(): OSType {
        return $this->osType;
    }

    function getTokens() {
        return $this->tokens;
    }

}
