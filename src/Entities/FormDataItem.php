<?php

namespace Informer\Entities;

class FormDataItem {

    private $formItem;
    private $value;

    function __construct(FormItem $formItem, $value) {
        $this->formItem = $formItem;
        $this->value = $value;
    }

    function getFormItem() : FormItem {
        return $this->formItem;
    }

    function getValue() {
        return $this->value;
    }

}
