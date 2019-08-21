<?php

namespace Informer\DTO\FB;

use Facebook\GraphNodes\GraphNode;
use Informer\Entities\Item;
use Informer\Enums\Source;

class PhotoDTO {

    public static function dataToModel(GraphNode $data): Item {
        $id = intval($data->getField("id"));
        $raw = $data->getField("name");
        $date = $data->getField("created_time");

        $pictures = array();

        array_push($pictures, PictureDTO::dataToModel($data));

        return new Item($id, $raw, $date, $pictures, Source::FB);
    }

}
