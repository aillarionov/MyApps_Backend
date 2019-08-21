<?php

namespace Informer\Entities;

use Exception;
use Informer\Enums\CatalogType;
use Informer\Enums\Source;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="catalog")
 * @HasLifecycleCallbacks
 * */
class Catalog extends BaseEntity {

    /**
     * @ManyToOne(targetEntity="Org", inversedBy="catalogs")
     * @JoinColumn(nullable=false)    
     * */
    private $org;

    /**
     * @Column(type="catalogtype", nullable=false)
     * */
    private $type;

    /**
     * @Column(type="source", nullable=false)
     * */
    private $source;

    /**
     * @OneToMany(targetEntity="MenuItem", mappedBy="catalog")
     * */
    private $menuItems;

    /** @Column(type="string", nullable=true) */
    private $sourceOwner;

    /** @Column(type="string", nullable=true) */
    private $sourceAlbum;

    /** @Column(type="json_array", nullable=true) */
    private $params;

    /** @Column(type="boolean", nullable=false) */
    private $visitorVisible;

    /** @Column(type="boolean", nullable=false) */
    private $presenterVisible;

    /** @Column(type="string", nullable=true) */
    private $visitorNotificationFilter;

    /** @Column(type="string", nullable=true) */
    private $presenterNotificationFilter;

    function getOrg() {
        return $this->org;
    }

    function getType(): CatalogType {
        return $this->type;
    }

    function getSource(): Source {
        return $this->source;
    }

    function setOrg($org) {
        $this->org = $org;
    }

    function setType(CatalogType $type) {
        $this->type = $type;
    }

    function setSource(Source $source) {
        $this->source = $source;
    }

    function getMenuItems() {
        return $this->menuItems;
    }

    function setMenuItems($menuItems) {
        $this->menuItems = $menuItems;
    }

    function getSourceOwner() {
        return $this->sourceOwner;
    }

    function getSourceAlbum() {
        return $this->sourceAlbum;
    }

    function setSourceOwner($sourceOwner) {
        $this->sourceOwner = $sourceOwner;
    }

    function setSourceAlbum($sourceAlbum) {
        $this->sourceAlbum = $sourceAlbum;
    }

    function getParams() {
        return $this->params;
    }

    function setParams($params) {
        $this->params = $params;
    }

    function getVisitorVisible() {
        return $this->visitorVisible;
    }

    function setVisitorVisible($visitorVisible) {
        $this->visitorVisible = $visitorVisible;
    }

    function getPresenterVisible() {
        return $this->presenterVisible;
    }

    function setPresenterVisible($presenterVisible) {
        $this->presenterVisible = $presenterVisible;
    }

    function getVisitorNotificationFilter() {
        return $this->visitorNotificationFilter;
    }

    function setVisitorNotificationFilter($visitorNotificationFilter) {
        $this->visitorNotificationFilter = $visitorNotificationFilter;
    }

    function getPresenterNotificationFilter() {
        return $this->presenterNotificationFilter;
    }

    function setPresenterNotificationFilter($presenterNotificationFilter) {
        $this->presenterNotificationFilter = $presenterNotificationFilter;
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

        if (empty($this->source)) {
            throw new Exception('source', 1001);
        }

        $this->visitorVisible = !!$this->visitorVisible;
        $this->presenterVisible = !!$this->presenterVisible;
    }

}
