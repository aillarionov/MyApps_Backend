<?php

namespace Informer\Entities;

use DateTime;
use Exception;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="vkconfirmation")
 * @HasLifecycleCallbacks
 * */
class VKConfirmation extends BaseEntity {

    /** @Column(type="integer", unique=true, nullable=false) */
    private $groupId;

    /** @Column(type="string", length=250, nullable=false) */
    private $confirmation;

    /**
     * @Column(type="datetime", nullable=false)
     * */
    private $lastUse;

    function getGroupId() {
        return $this->groupId;
    }

    function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    function getConfirmation() {
        return $this->confirmation;
    }

    function setConfirmation($confirmation) {
        $this->confirmation = $confirmation;
    }

    function getLastUse() {
        return $this->lastUse;
    }

    function update() {
        $this->lastUse = new DateTime();
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
        if (empty($this->groupId)) {
            throw new Exception('groupId', 1001);
        }

        if (empty($this->confirmation)) {
            throw new Exception('confirmation', 1001);
        }

        if (empty($this->lastUse)) {
            $this->lastUse = new DateTime();
        }
    }

}
