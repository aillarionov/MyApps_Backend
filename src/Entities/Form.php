<?php

namespace Informer\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="form")
 * @HasLifecycleCallbacks
 * */
class Form extends BaseEntity {

    /**
     * @ManyToOne(targetEntity="Org", inversedBy="catalogs")
     * @JoinColumn(nullable=false, onDelete="CASCADE")       
     * */
    private $org;

    /** @Column(type="string", length=100, nullable=false) */
    private $name;

    /** @Column(type="string", length=250, nullable=true) */
    private $dataEmail;

    /**
     * @OneToMany(targetEntity="FormItem", mappedBy="form", orphanRemoval=true, cascade={"persist", "remove"})
     * @OrderBy({"order" = "ASC"})
     * */
    private $items;

    /**
     * @OneToMany(targetEntity="MenuItem", mappedBy="form")
     * */
    private $menuItems;

    function __construct() {
        parent::__construct();
        $this->items = new ArrayCollection();
        $this->menuItems = new ArrayCollection();
    }
    
    function getOrg(): Org {
        return $this->org;
    }

    function setOrg(Org $org) {
        $this->org = $org;
    }

    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getDataEmail() {
        return $this->dataEmail;
    }

    function setDataEmail($dataEmail) {
        $this->dataEmail = $dataEmail;
    }

    function getItems() {
        return $this->items;
    }

    function setItems($items) {
        $this->items = $items;
    }

    function getMenuItems() {
        return $this->menuItems;
    }

    function setMenuItems($menuItems) {
        $this->menuItems = $menuItems;
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
        if (empty($this->org)) {
            throw new Exception('org', 1001);
        }

        if (empty($this->name)) {
            throw new Exception('name', 1001);
        }
    }

}
