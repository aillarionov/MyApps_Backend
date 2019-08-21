<?php

namespace Informer\Entities;

use Exception;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="`city`")
 * @HasLifecycleCallbacks
 * */
class City extends BaseEntity {

    /** @Column(type="string", length=50, unique=true, nullable=false) */
    protected $name;

    /**
     * @OneToMany(targetEntity="Org", mappedBy="city")
     * */
    private $orgs;

    function __construct() {
        parent::__construct();
        $this->orgs = new ArrayCollection();
    }

    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getOrgs() {
        return $this->orgs;
    }

    function setOrgs($orgs) {
        $this->orgs = $orgs;
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
        if (empty($this->name)) {
            throw new Exception('name', 1001);
        }
    }

}
