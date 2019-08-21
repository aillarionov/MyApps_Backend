<?php

namespace Informer\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Informer\Enums\OSType;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="clientToken", uniqueConstraints={@UniqueConstraint(columns={"tokenId", "osType"})})
 * @HasLifecycleCallbacks
 * */
class ClientToken extends BaseEntity {

    /** @Column(type="string", length=250, nullable=false) */
    private $tokenId;

    /**
     * @Column(type="ostype", nullable=false)
     */
    private $osType;

    /**
     * @Column(type="datetime", nullable=false)
     * */
    private $lastChange;

    /**
     * @OneToMany(targetEntity="ClientTokenOrg", mappedBy="clientToken", cascade={"persist", "remove"})
     * */
    private $clientTokenOrgs;

    function __construct() {
        parent::__construct();

        $this->clientTokenOrgs = new ArrayCollection();
    }

    function getTokenId() {
        return $this->tokenId;
    }

    function setTokenId($tokenId) {
        $this->tokenId = $tokenId;
    }

    function getOsType(): OSType {
        return $this->osType;
    }

    function setOsType(OSType $osType) {
        $this->osType = $osType;
    }

    function getClientTokenOrgs() {
        return $this->clientTokenOrgs;
    }

    function setClientTokenOrgs($clientTokenOrgs) {
        $this->clientTokenOrgs = $clientTokenOrgs;
    }

    function getLastChange() {
        return $this->lastChange;
    }

    function update() {
        $this->lastChange = new DateTime();
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
        if (empty($this->tokenId)) {
            throw new Exception('tokenId', 1001);
        }

        if (empty($this->lastChange)) {
            $this->lastChange = new DateTime();
        }
    }

}
