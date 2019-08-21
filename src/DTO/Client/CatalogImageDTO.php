<?php

namespace Informer\DTO\Client;

use DateTime;
use Informer\Entities\Item;
use Informer\Proxy\Client\CatalogImageProxy;

class CatalogImageDTO {

    public static function modelToProxy(Item $model): CatalogImageProxy {
        $date = $model->getDate()->format(DateTime::ISO8601);

        $pictures = array();

        foreach ($model->getPictures() as $picture) {
            array_push($pictures, PictureDTO::modelToProxy($picture));
        }

        return new CatalogImageProxy(
                $model->getId(), $date, $pictures
        );
    }

}
