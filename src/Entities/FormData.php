<?php

namespace Informer\Entities;

class FormData {

    private $form;
    private $data;

    function __construct(Form $form, array $data) {
        $this->form = $form;
        $this->data = $data;
    }

    function getForm() : Form {
        return $this->form;
    }

    function getData() : array {
        return $this->data;
    }

}
