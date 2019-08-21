<?php

namespace Informer\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="org")
 * @HasLifecycleCallbacks
 * */
class Org extends BaseEntity {

    /** @Column(type="string", length=100, unique=true, nullable=false) */
    private $name;

    /** @Column(type="string", length=1000, nullable=false) */
    private $logo;

    /** @Column(name="`order`", type="integer", nullable=false) */
    private $order;

    /** @Column(type="string", length=10, nullable=true, unique=true) */
    private $code;

    /**
     * @OneToMany(targetEntity="Catalog", mappedBy="org", orphanRemoval=true, cascade={"persist", "remove"})
     * */
    private $catalogs;

    /**
     * @OneToMany(targetEntity="Form", mappedBy="org", orphanRemoval=true, cascade={"persist", "remove"})
     * */
    private $forms;

    /**
     * @OneToMany(targetEntity="MenuItem", mappedBy="org", orphanRemoval=true, cascade={"persist", "remove"})
     * */
    private $menuItems;

    /**
     * @OneToOne(targetEntity="Ticket", mappedBy="org", orphanRemoval=true, cascade={"persist", "remove"})
     * @JoinColumn(nullable=true, onDelete="SET NULL")      
     * */
    private $ticket;

    /**
     * @OneToMany(targetEntity="ClientTokenOrg", mappedBy="org")
     * */
    private $clientTokenOrgs;

    /**
     * @OneToMany(targetEntity="ClientAdOrg", mappedBy="org")
     * */
    private $clientAdOrgs;

    /**
     * @OneToMany(targetEntity="NotificationOrg", mappedBy="org")
     * */
    private $notificationOrgs;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="orgs")
     * @JoinColumn(nullable=false)       
     * */
    private $user;
    
    /**
     * @ManyToOne(targetEntity="City", inversedBy="orgs")
     * @JoinColumn(nullable=false)       
     * */
    private $city;

    /** @Column(type="boolean", nullable=false) */
    private $suspend;

    function __construct() {
        parent::__construct();
        $this->catalogs = new ArrayCollection();
        $this->forms = new ArrayCollection();
        $this->menuItems = new ArrayCollection();
        $this->clientTokenOrgs = new ArrayCollection();
        $this->clientAdOrgs = new ArrayCollection();
        $this->notificationOrgs = new ArrayCollection();
        $this->suspend = true;
    }

    function getName() {
        return $this->name;
    }

    function getLogo() {
        return $this->logo;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }

    function getOrder() {
        return $this->order;
    }

    function setOrder($order) {
        $this->order = $order;
    }

    function getCode() {
        return $this->code;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function getCatalogs() {
        return $this->catalogs;
    }

    function setCatalogs($catalogs) {
        $this->catalogs = $catalogs;
    }

    function getForms() {
        return $this->forms;
    }

    function setForms($forms) {
        $this->forms = $forms;
    }

    function getMenuItems() {
        return $this->menuItems;
    }

    function setMenuItems($menuItems) {
        $this->menuItems = $menuItems;
    }

    function getClientTokenOrgs() {
        return $this->clientTokenOrgs;
    }

    function setClientTokenOrgs($clientTokenOrgs) {
        $this->clientTokenOrgs = $clientTokenOrgs;
    }

    function getClientAdOrgs() {
        return $this->clientAdOrgs;
    }

    function setClientAdOrgs($clientAdOrgs) {
        $this->clientAdOrgs = $clientAdOrgs;
    }

    function getTicket() {
        return $this->ticket;
    }

    function setTicket($ticket) {
        $this->ticket = $ticket;
    }

    function getNotificationOrgs() {
        return $this->notificationOrgs;
    }

    function setNotificationOrgs($notificationOrgs) {
        $this->notificationOrgs = $notificationOrgs;
    }

    function getUser() {
        return $this->user;
    }

    function getSuspend() {
        return $this->suspend;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setSuspend($suspend) {
        $this->suspend = $suspend;
    }

    function getCity() {
        return $this->city;
    }

    function setCity($city) {
        $this->city = $city;
    }

        
    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
        if (empty($this->name)) {
            throw new Exception('name', 1001);
        }

        if (empty($this->logo)) {
            throw new Exception('logo', 1002);
        }

        if (empty($this->user)) {
            throw new Exception('user', 1003);
        }
        
        if (empty($this->city)) {
            throw new Exception('city', 1004);
        }
    }

}
