<?php

namespace Informer\Entities;

use Exception;
use Informer\Enums\MenuItemType;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="menuItem", uniqueConstraints={@UniqueConstraint(columns={"org_id", "order"})})
 * @HasLifecycleCallbacks
 * */
class MenuItem extends BaseEntity {

    /**
     * @ManyToOne(targetEntity="Org", inversedBy="catalogs")
     * @JoinColumn(nullable=false, onDelete="CASCADE")        
     * */
    private $org;

    /**
     * @Column(type="menuitemtype", nullable=false)
     */
    private $type;

    /** @Column(type="string", length=100, nullable=false) */
    private $name;

    /** @Column(type="string", length=50, nullable=true) */
    private $icon;

    /**
     * @ManyToOne(targetEntity="Catalog", inversedBy="menuItems")
     * @JoinColumn(nullable=true, onDelete="SET NULL")        
     * */
    private $catalog;

    /**
     * @ManyToOne(targetEntity="Form", inversedBy="menuItems")
     * @JoinColumn(nullable=true, onDelete="SET NULL")        
     * */
    private $form;

    /** @Column(type="json_array", nullable=true) */
    private $params;

    /** @Column(type="integer", nullable=false, name="`order`") */
    private $order;

    function getOrg() {
        return $this->org;
    }

    function getType(): MenuItemType {
        return $this->type;
    }

    function getName() {
        return $this->name;
    }

    function getIcon() {
        return $this->icon;
    }

    function getParams() {
        return $this->params;
    }

    function setOrg($org) {
        $this->org = $org;
    }

    function setType(MenuItemType $type) {
        $this->type = $type;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setIcon($icon) {
        $this->icon = $icon;
    }

    function setParams($params) {
        $this->params = $params;
    }

    function getCatalog() {
        return $this->catalog;
    }

    function setCatalog($catalog) {
        $this->catalog = $catalog;
    }

    function getForm() {
        return $this->form;
    }

    function setForm($form) {
        $this->form = $form;
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
        if (empty($this->org)) {
            throw new Exception('org', 1001);
        }

        if (empty($this->type)) {
            throw new Exception('type', 1001);
        }

        if (empty($this->name)) {
            throw new Exception('name', 1001);
        }
    }

}
