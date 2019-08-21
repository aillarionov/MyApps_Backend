<?php

namespace Informer\DTO\VK;

use DateTime;
use Informer\Converter\VK\TextConverter;
use Informer\Entities\Item;
use Informer\Enums\Source;

class PostDTO {

    public static function dataToModel($data): Item {
        $pictures = array();

        $id = $data["id"];
        $date = DateTime::createFromFormat("U", $data["date"]);

        $post = $data;
        $max = 10; // Защита от зацикливания

        while (isset($post['copy_history']) && $max > 0) {
            $post = $post['copy_history'][0];
            $max--;
        }

        $raw = $post["text"];

        if (isset($post["attachments"])) {
            static::parseAttachments($post["attachments"], $raw, $pictures);
        }

        return new Item($id, $raw, $date, $pictures, Source::VK);
    }

    private static function parseAttachments($attachments, &$text, &$pictures) {
        foreach ($attachments as $attachment) {
            switch ($attachment["type"]) {
                case "photo":
                    array_push($pictures, PictureDTO::dataToModel($attachment["photo"]));
                    break;

//                case "video":
//                    array_push($pictures, PictureDTO::dataToModel($attachment["video"]));
//                    break;

                case "link":
                    TextConverter::applyLinkToText($text, $attachment["link"]);
                    break;

                default:
                    break;
            }
        }
    }

}
