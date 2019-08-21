<?php

namespace Informer\Entities;

class AuthData {

    private $login;
    private $password;

    function __construct($login, $password) {
        $this->login = $login;
        $this->password = $password;
    }

    function getLogin() {
        return $this->login;
    }

    function getPassword() {
        return $this->password;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setPassword($password) {
        $this->password = $password;
    }

}
