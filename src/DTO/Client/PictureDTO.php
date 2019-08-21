<?php

namespace Informer\DTO\Client;

use Informer\Entities\Picture;
use Informer\Proxy\Client\PictureProxy;

class PictureDTO {

    public static function modelToProxy(Picture $model): PictureProxy {
        $images = array();

        foreach ($model->getImages() as $image) {
            array_push($images, ImageDTO::modelToProxy($image));
        }
        
        return new PictureProxy($images);
    }

}
