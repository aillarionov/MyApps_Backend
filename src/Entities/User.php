<?php

namespace Informer\Entities;

use Exception;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="`user`")
 * @HasLifecycleCallbacks
 * */
class User extends BaseEntity {

    /** @Column(type="string", length=50, unique=true, nullable=true) */
    protected $login;

    /** @Column(type="password", nullable=true) */
    protected $password;

    /** @Column(type="boolean", options={"default"=false}) */
    protected $locked;

    /** @Column(type="boolean", options={"default"=false}) */
    protected $isAdmin;

    /**
     * @OneToMany(targetEntity="Org", mappedBy="user")
     * */
    private $orgs;

    function __construct() {
        parent::__construct();
        $this->orgs = new ArrayCollection();
    }

    function getLogin() {
        return $this->login;
    }

    function getLocked() {
        return $this->locked;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function checkPassword($password) {
        if (is_callable($this->password)) {
            $a = $this->password;
            return $a($password);
        } else {
            return $password == $this->password;
        }
    }

    function setLocked($locked) {
        $this->locked = $locked;
    }

    function getIsAdmin() {
        return $this->isAdmin;
    }

    function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
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
        if (empty($this->login)) {
            throw new Exception('login', 1001);
        }

        if (empty($this->password)) {
            throw new Exception('password', 1002);
        }
    }

}
