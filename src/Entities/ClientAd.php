<?php

namespace Informer\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Informer\Enums\OSType;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="clientAd", uniqueConstraints={@UniqueConstraint(columns={"adId", "osType"})})
 * @HasLifecycleCallbacks
 * */
class ClientAd extends BaseEntity {

    /** @Column(type="string", length=250, nullable=false) */
    private $adId;

    /**
     * @Column(type="ostype", nullable=false)
     */
    private $osType;

    /**
     * @Column(type="datetime", nullable=false)
     * */
    private $lastChange;

    /**
     * @OneToMany(targetEntity="ClientAdOrg", mappedBy="clientAd", cascade={"persist", "remove"})
     * */
    private $clientAdOrgs;

    function __construct() {
        parent::__construct();

        $this->clientAdOrgs = new ArrayCollection();
    }

    function getAdId() {
        return $this->adId;
    }

    function setAdId($adId) {
        $this->adId = $adId;
    }

    function getOsType(): OSType {
        return $this->osType;
    }

    function setOsType(OSType $osType) {
        $this->osType = $osType;
    }

    function getClientAdOrgs() {
        return $this->clientAdOrgs;
    }

    function setClientAdOrgs($clientAdOrgs) {
        $this->clientAdOrgs = $clientAdOrgs;
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
        if (empty($this->adId)) {
            throw new Exception('adId', 1001);
        }
        
        if (empty($this->lastChange)) {
            $this->lastChange = new DateTime();
        }
    }

}
