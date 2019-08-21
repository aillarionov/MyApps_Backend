<?php

namespace Informer\DTO\FB;

use Facebook\GraphNodes\GraphNode;
use Informer\Entities\Image;

class ImageDTO {

    public static function dataToModel(GraphNode $data) : Image {
        $width = $data->getField("width");
        $height = $data->getField("height");
        $source = $data->getField("source") ?? $data->getField("src");
        
        
        return new Image($width, $height, $source);
    }
    
}
