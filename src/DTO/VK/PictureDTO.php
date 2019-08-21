<?php

namespace Informer\DTO\VK;

use DateTime;
use Informer\Entities\Picture;

class PictureDTO {

    public static function dataToModel($data): Picture {
        $images = array();

        $width = intval($data["width"]);
        $height = intval($data["height"]);

        foreach ($data as $key => $val) {
            if (substr($key, 0, 5) == "photo") {
                $p_height = intval(substr($key, 6, strlen($key) - 6));

                if ($p_height > $height) {
                    $p_height = $height;
                    $p_width = $width;
                } else {
                    $p_width = $height > 0 ? intval($width * $p_height / $height) : 0;
                }


                array_push($images, ImageDTO::dataToModel(array(
                            "width" => $p_width,
                            "height" => $p_height,
                            "source" => $val
                )));
            }
        }

        return new Picture($images);
    }

}
