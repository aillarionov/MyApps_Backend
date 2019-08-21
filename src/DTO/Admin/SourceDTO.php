<?php

namespace Informer\DTO\Admin;

use Informer\Enums\Source;

class SourceDTO {

    public static function modelToProxy(Source $model): string {
       return $model->getValue();
    }

    public static function rawToModel(string $raw): Source {
        return new Source($raw);
    }
}
