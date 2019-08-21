<?php

namespace Informer\DTO\Client;

use Informer\Entities\Image;
use Informer\Proxy\Client\ImageProxy;

class ImageDTO {

    public static function modelToProxy(Image $model): ImageProxy {
        return new ImageProxy(
                $model->getWidth(), $model->getHeight(), $model->getSource()
        );
    }

}
