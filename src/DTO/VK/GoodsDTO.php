<?php

namespace Informer\DTO\VK;

use DateTime;
use Informer\Converter\VK\TextConverter;
use Informer\Entities\Item;
use Informer\Enums\Source;

class GoodsDTO {

   public static function dataToModel($data): Item {
        $id = $data["id"];
        $raw = $data["description"];
        $date = DateTime::createFromFormat("U", $data["date"]);

        $pictures = array();

        return new Item($id, $raw, $date, $pictures, Source::VK);
    }

}
