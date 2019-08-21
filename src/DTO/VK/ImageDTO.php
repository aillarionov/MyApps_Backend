<?php

namespace Informer\DTO\VK;

use Informer\Entities\Image;

class ImageDTO {

    public static function dataToModel($data) : Image {
        $width = $data["width"];
        $height = $data["height"];
        $source = $data["source"];
        
        return new Image($width, $height, $source);
    }
    
}
