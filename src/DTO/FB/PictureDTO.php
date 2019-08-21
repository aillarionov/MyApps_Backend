<?php

namespace Informer\DTO\FB;

use Facebook\GraphNodes\GraphNode;
use Informer\Entities\Picture;

class PictureDTO {

    public static function dataToModel(GraphNode $data): Picture {
        $images = array();

        if ($data->getField("images")) {
            foreach ($data->getField("images") as $image) {
                array_push($images, ImageDTO::dataToModel($image));
            }
        }

        if ($data->getField("image")) {
            array_push($images, ImageDTO::dataToModel($data->getField("image")));
        }

        return new Picture($images);
    }

}
