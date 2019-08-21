<?php

namespace Informer\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="notification")
 * @HasLifecycleCallbacks
 * */
class Notification extends BaseEntity {

    /**
     * @OneToMany(targetEntity="NotificationOrg", mappedBy="notification", cascade={"persist", "remove"})
     * */
    private $notificationOrgs;

    /** @Column(type="string", length=500, nullable=false) */
    private $text;

    /** @Column(type="string", length=500, nullable=true) */
    private $data;

    /** @Column(type="datetime", nullable=true) */
    private $sent;

    function __construct() {
        parent::__construct();
        $this->notificationOrgs = new ArrayCollection();
    }

    function getNotificationOrgs() {
        return $this->notificationOrgs;
    }

    function addNotificationOrg(NotificationOrg $notificationOrg) {
        $this->notificationOrgs->add($notificationOrg);
    }

    function setNotificationOrgs($notificationOrgs) {
        $this->notificationOrgs = $notificationOrgs;
    }

    function getText() {
        return $this->text;
    }

    function setText($text) {
        $this->text = $text;
    }

    function getData() {
        return $this->data;
    }

    function setData($data) {
        $this->data = $data;
    }

    function getSent() {
        return $this->sent;
    }

    function setSent() {
        $this->sent = new DateTime();
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
        if (empty($this->text)) {
            throw new Exception('text', 1001);
        }

        if ($this->notificationOrgs->isEmpty()) {
            throw new Exception('notificationOrgs', 1001);
        }
    }

}
