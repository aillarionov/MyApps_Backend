<?php

namespace Informer\DTO\VK;

use DateTime;
use Informer\Entities\Item;
use Informer\Enums\Source;

class PhotoDTO {

    public static function dataToModel($data): Item {
        $id = $data["id"];
        $raw = $data["text"];
        $date = DateTime::createFromFormat("U", $data["date"]);

        $pictures = array();
        array_push($pictures, PictureDTO::dataToModel($data));

        return new Item($id, $raw, $date, $pictures, Source::VK);
    }

}
