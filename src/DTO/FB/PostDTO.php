<?php

namespace Informer\DTO\FB;

use Facebook\GraphNodes\GraphEdge;
use Facebook\GraphNodes\GraphNode;
use Informer\DTO\FB\PictureDTO;
use Informer\Entities\Item;
use Informer\Enums\Source;

class PostDTO {

    public static function dataToModel(GraphNode $data): Item {
        $id = $data->getField("id");
        $id = intval(substr($id, strpos($id, "_") + 1));

        $raw = $data->getField("message");
        $date = $data->getField("created_time");
        
        $pictures = array();

        if ($data->getField("attachments")) {
            static::parseAttachments($data->getField("attachments"), $pictures);
        }

        return new Item($id, $raw, $date, $pictures, Source::FB);
    }

    private static function parseAttachments(GraphEdge $attachments, &$pictures) {
        foreach ($attachments->all() as $item) {

            $media = $item->getField("media");
            if ($media && $media->getField("image")) {
                array_push($pictures, PictureDTO::dataToModel($media));
            }

            if ($item->getField('subattachments')) {
                static::parseAttachments($item->getField("subattachments"), $pictures);
            }
        }
    }

}
