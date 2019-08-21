<?php

namespace Informer\DTO\Admin;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\Entities\Org;
use Informer\Entities\Ticket;
use Informer\Proxy\Admin\TicketProxy;

class TicketDTO {

    public static function modelToProxy(Ticket $model): TicketProxy {
        return new TicketProxy($model->getId(), TicketTypeDTO::modelToProxy($model->getType()), $model->getSource(), $model->getText(), $model->getButton());
    }

    public static function rawToModel(EntityManager $em, Org $org, array $raw): Ticket {
        $id = isset($raw['id']) ? intVal($raw['id']) : null;
        if (!$id) {
            throw new Exception("Ticket id not specified", 2001);
        }

        $ticket = static::getEntity($em, $org, $id);
        if (!$ticket) {
            $ticket = new Ticket();
            $ticket->setOrg($org);
        }

        static::fillModelFromRaw($ticket, $raw);

        return $ticket;
    }

    public static function getEntity(EntityManager $em, Org $org, int $id)/* TODO: : ?Ticket */ {
        return $em->getRepository(Ticket::class)->findOneBy(array("org" => $org, "id" => $id));
    }

    private static function fillModelFromRaw(Ticket $model, array $raw) {

        if (isset($raw['type'])) {
            $model->setType(TicketTypeDTO::rawToModel($raw['type']));
        }

        if (isset($raw['name'])) {
            $model->setName($raw['name']);
        }

        if (isset($raw['source'])) {
            $model->setSource($raw['source']);
        }

        if (isset($raw['text'])) {
            $model->setText($raw['text']);
        }

        if (isset($raw['button'])) {
            $model->setButton($raw['button']);
        }
    }

}
