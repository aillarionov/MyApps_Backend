<?php

namespace Informer\DTO\Client;

use DateTime;
use Informer\Converter\Client\TextConverter;
use Informer\Entities\Item;
use Informer\Proxy\Client\CatalogItemProxy;

class CatalogItemDTO {

    public static function modelToProxy(Item $model): CatalogItemProxy {
        $text = TextConverter::textToHTML($model->getRaw(), $model->getSource());
        $date = $model->getDate()->format(DateTime::ISO8601);

        $pictures = array();

        foreach ($model->getPictures() as $picture) {
            array_push($pictures, PictureDTO::modelToProxy($picture));
        }

        return new CatalogItemProxy(
                $model->getId(), $text, $date, $pictures, $model->getRaw()
        );
    }

}
