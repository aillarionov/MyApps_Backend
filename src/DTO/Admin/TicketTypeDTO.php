<?php

namespace Informer\DTO\Admin;

use Informer\Enums\TicketType;

class TicketTypeDTO {

    public static function modelToProxy(TicketType $model): string {
       return $model->getValue();
    }

    public static function rawToModel(string $raw): TicketType {
        return new TicketType($raw);
    }
}
