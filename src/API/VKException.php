<?php

namespace Informer\API;

use LoggedException;

class VKException extends LoggedException {

    protected $requestParams;
    
    public function __construct($data, Exception $previous = null) {
        $this->requestParams = $data["request_params"];
        $code = $data["error_code"];
        $message = $data["error_msg"];

        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
    public function getRequestParams() {
        return $this->requestParams;
    }
    
     protected function getPayload(){
        return $this->getRequestParams();
    }

}
