<?php

namespace Informer\Entities;

use Exception;
use Informer\Enums\TicketType;
use Informer\Utils\Entity\BaseEntity;

/**
 * @Entity @Table(name="ticket")
 * @HasLifecycleCallbacks
 * */
class Ticket extends BaseEntity {

    /**
     * @OneToOne(targetEntity="Org", inversedBy="ticket")
     * @JoinColumn(nullable=false, onDelete="CASCADE")       
     * */
    private $org;

    /**
     * @Column(type="tickettype", nullable=false)
     */
    private $type;

    /** @Column(type="string", length=1000, nullable=true) */
    private $source;

    /** @Column(type="string", length=1000, nullable=true) */
    private $text;

    /** @Column(type="string", length=50, nullable=true) */
    private $button;
    
    function getOrg() {
        return $this->org;
    }

    function setOrg($org) {
        $this->org = $org;
    }

    function getType(): TicketType {
        return $this->type;
    }

    function setType(TicketType $type) {
        $this->type = $type;
    }

    function getSource() {
        return $this->source;
    }

    function setSource($source) {
        $this->source = $source;
    }

    function getText() {
        return $this->text;
    }

    function setText($text) {
        $this->text = $text;
    }

    function getButton() {
        return $this->button;
    }

    function setButton($button) {
        $this->button = $button;
    }
        
    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
        if (empty($this->org)) {
            throw new Exception('name', 1001);
        }

        if (empty($this->type)) {
            throw new Exception('type', 1001);
        }
    }

}
