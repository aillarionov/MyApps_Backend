<?php

namespace Informer\DTO\Client;

use Informer\Enums\TicketType;

class TicketTypeDTO {

    public static function modelToProxy(TicketType $model): string {
        return $model->getValue();
    }

}
