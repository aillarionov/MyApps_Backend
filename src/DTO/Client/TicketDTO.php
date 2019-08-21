<?php

namespace Informer\DTO\Client;

use Informer\Entities\Ticket;
use Informer\Proxy\Client\TicketProxy;

class TicketDTO {

    public static function modelToProxy(Ticket $model): TicketProxy {
        return new TicketProxy(TicketTypeDTO::modelToProxy($model->getType()), $model->getSource(), $model->getText(), $model->getButton());
    }

}
