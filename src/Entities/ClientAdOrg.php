<?php

namespace Informer\Entities;

use Exception;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="clientAd_org", uniqueConstraints={@UniqueConstraint(columns={"clientAd_id", "org_id"})})
 * @HasLifecycleCallbacks
 * */
class ClientAdOrg extends BaseEntity {

    /**
     * @ManyToOne(targetEntity="ClientAd", inversedBy="clientAdOrgs")
     * @JoinColumn(nullable=false, onDelete="CASCADE")     
     * */
    private $clientAd;

    /**
     * @ManyToOne(targetEntity="Org", inversedBy="clientAdOrgs")
     * @JoinColumn(nullable=false, onDelete="CASCADE")  
     * */
    private $org;

    function getClientAd() {
        return $this->clientAd;
    }

    function getOrg() {
        return $this->org;
    }

    function setClientAd($clientAd) {
        $this->clientAd = $clientAd;
    }

    function setOrg($org) {
        $this->org = $org;
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
        if (empty($this->clientAd)) {
            throw new Exception('clientAd', 1001);
        }

        if (empty($this->org)) {
            throw new Exception('org', 1001);
        }
    }

}
