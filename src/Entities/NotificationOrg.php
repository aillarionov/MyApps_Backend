<?php

namespace Informer\Entities;

use Exception;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="notification_org", uniqueConstraints={@UniqueConstraint(columns={"notification_id", "org_id"})})
 * @HasLifecycleCallbacks
 * */
class NotificationOrg extends BaseEntity {

    /**
     * @ManyToOne(targetEntity="Notification", inversedBy="notificationOrgs")
     * @JoinColumn(nullable=false, onDelete="CASCADE")
     * */
    private $notification;

    /**
     * @ManyToOne(targetEntity="Org", inversedBy="notificationOrgs")
     * @JoinColumn(nullable=false, onDelete="CASCADE")
     * */
    private $org;

    /** @Column(type="boolean", nullable=false) */
    private $forVisitor;

    /** @Column(type="boolean", nullable=false) */
    private $forPresenter;

    function getNotification() {
        return $this->notification;
    }

    function setNotification($notification) {
        $this->notification = $notification;
    }

    function getOrg() {
        return $this->org;
    }

    function setOrg($org) {
        $this->org = $org;
    }

    function getForVisitor() {
        return $this->forVisitor;
    }

    function setForVisitor($forVisitor) {
        $this->forVisitor = $forVisitor;
    }

    function getForPresenter() {
        return $this->forPresenter;
    }

    function setForPresenter($forPresenter) {
        $this->forPresenter = $forPresenter;
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
        if (empty($this->notification)) {
            throw new Exception('notification', 1001);
        }

        if (empty($this->org)) {
            throw new Exception('org', 1001);
        }
    }

}
