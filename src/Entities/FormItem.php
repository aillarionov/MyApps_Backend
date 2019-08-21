<?php

namespace Informer\Entities;

use Exception;
use Informer\Enums\FormItemType;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="formItem", uniqueConstraints={@UniqueConstraint(columns={"form_id", "order"})})
 * @HasLifecycleCallbacks
 * */
class FormItem extends BaseEntity {

    /**
     * @ManyToOne(targetEntity="Form", inversedBy="items")
     * @JoinColumn(nullable=false, onDelete="CASCADE")      
     * */
    private $form;

    /**
     * @Column(type="formitemtype", nullable=false)
     */
    private $type;

    /** @Column(type="string", length=100, nullable=false) */
    private $name;

    /** @Column(type="string", length=100, nullable=false) */
    private $title;

    /** @Column(type="boolean", nullable=false) */
    private $required;

    /** @Column(type="json_array", nullable=true) */
    private $params;

    /** @Column(type="integer", nullable=false, name="`order`") */
    private $order;

    function getForm() : Form {
        return $this->form;
    }

    function getType(): FormItemType {
        return $this->type;
    }

    function getName() {
        return $this->name;
    }

    function getTitle() {
        return $this->title;
    }

    function getRequired() {
        return $this->required;
    }

    function getParams() {
        return $this->params;
    }

    function setForm($form) {
        $this->form = $form;
    }

    function setType(FormItemType $type) {
        $this->type = $type;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setRequired($required) {
        $this->required = $required;
    }

    function setParams($params) {
        $this->params = $params;
    }

    function getOrder() {
        return $this->order;
    }

    function setOrder($order) {
        $this->order = $order;
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
        if (empty($this->form)) {
            throw new Exception('form', 1001);
        }

        if (empty($this->type)) {
            throw new Exception('type', 1001);
        }

        if (empty($this->name)) {
            throw new Exception('name', 1001);
        }

        if (empty($this->title)) {
            throw new Exception('title', 1001);
        }

        $this->required = !!$this->name;
    }

}
