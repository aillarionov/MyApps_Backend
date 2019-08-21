<?php

namespace Informer\Entities;

use Exception;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="clientToken_org", uniqueConstraints={@UniqueConstraint(columns={"clientToken_id", "org_id"})})
 * @HasLifecycleCallbacks
 * */
class ClientTokenOrg extends BaseEntity {

    /**
     * @ManyToOne(targetEntity="ClientToken", inversedBy="clientTokenOrgs")
     * @JoinColumn(nullable=false, onDelete="CASCADE")    
     * */
    private $clientToken;

    /**
     * @ManyToOne(targetEntity="Org", inversedBy="clientTokenOrgs")
     * @JoinColumn(nullable=false, onDelete="CASCADE")
     * */
    private $org;

    /** @Column(type="boolean", nullable=false) */
    private $isVisitor;

    /** @Column(type="boolean", nullable=false) */
    private $isPresenter;

    /** @Column(type="boolean", nullable=false) */
    private $receiveNotifications;

    function setClientToken($clientToken) {
        $this->clientToken = $clientToken;
    }

    function setOrg($org) {
        $this->org = $org;
    }

    function getClientToken() {
        return $this->clientToken;
    }

    function getOrg() {
        return $this->org;
    }

    function getIsVisitor() {
        return $this->isVisitor;
    }

    function getIsPresenter() {
        return $this->isPresenter;
    }

    function getReceiveNotifications() {
        return $this->receiveNotifications;
    }

    function setIsVisitor($isVisitor) {
        $this->isVisitor = $isVisitor;
    }

    function setIsPresenter($isPresenter) {
        $this->isPresenter = $isPresenter;
    }

    function setReceiveNotifications($receiveNotifications) {
        $this->receiveNotifications = $receiveNotifications;
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
        if (empty($this->clientToken)) {
            throw new Exception('clientToken', 1001);
        }

        if (empty($this->org)) {
            throw new Exception('org', 1001);
        }
    }

}
