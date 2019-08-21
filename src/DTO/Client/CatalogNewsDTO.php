<?php

namespace Informer\DTO\Client;

use DateTime;
use Informer\Converter\Client\TextConverter;
use Informer\Entities\Item;
use Informer\Proxy\Client\CatalogNewsProxy;

class CatalogNewsDTO {

    public static function modelToProxy(Item $model): CatalogNewsProxy {
        $text = TextConverter::textToHTML($model->getRaw(), $model->getSource());
        $date = $model->getDate()->format(DateTime::ISO8601);

        $pictures = array();

        foreach ($model->getPictures() as $picture) {
            array_push($pictures, PictureDTO::modelToProxy($picture));
        }

        return new CatalogNewsProxy(
                $model->getId(), $text, $date, $pictures, $model->getRaw()
        );
    }

}
