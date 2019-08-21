<?php

namespace Informer\Utils\REST;

class EndpointFunction {

    private $resultType;
    private $cacheable;
    private $authRequired;
    private $function;

    function __construct($resultType, $cacheable, $authRequired, $function) {
        $this->resultType = $resultType;
        $this->cacheable = $cacheable;
        $this->authRequired = $authRequired;
        $this->function = $function;
    }

    function getFunction() {
        return $this->function;
    }

    function getResultType() {
        return $this->resultType;
    }

    function getAuthRequired() {
        return $this->authRequired;
    }
    
    function getCacheable() {
        return $this->cacheable;
    }

}
