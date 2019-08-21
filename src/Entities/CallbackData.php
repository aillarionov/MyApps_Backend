<?php

namespace Informer\Entities;

class CallbackData {

    private $email;
    private $phone;
    private $subject;

    function __construct($email, $phone, $subject) {
        $this->email = $email;
        $this->phone = $phone;
        $this->subject = $subject;
    }

    function getEmail() {
        return $this->email;
    }

    function getPhone() {
        return $this->phone;
    }

    function getSubject() {
        return $this->subject;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

}
