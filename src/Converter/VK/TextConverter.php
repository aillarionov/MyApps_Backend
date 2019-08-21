<?php

namespace Informer\Converter\VK;

class TextConverter {

    public static function applyLinkToText(&$text, $data) {
        $url = isset($data["url"]) ? $data["url"] : null;
        $title = isset($data["title"]) ? $data["title"] : null;
        $description = isset($data["description"]) ? $data["description"] : null;

        if ($url) {
            $link = str_replace("{url}", $url, LINK_TEMPLATE);
            $link = str_replace("{title}", $title, $link);
            $link = str_replace("{description}", $description, $link);
        }

        $text = str_replace($url, $link, $text);
    }

    public static function convertHashToLink(&$text) {
        $text = preg_replace_callback("/\#([\w\d]+)/ui", function ($match) {
            $result = str_replace("{text}", $match[0], VK_HASH_TEMPLATE);
            $result = str_replace("{hash}", $match[1], $result);
            return $result;
        }, $text);
    }

    public static function convertGroupToLink(&$text) {
        $text = preg_replace_callback("/\[([\w\d]+)\|([^\]]+)\]/ui", function ($match) {
            $result = str_replace("{text}", $match[0], VK_GROUP_TEMPLATE);
            $result = str_replace("{id}", $match[1], $result);
            $result = str_replace("{name}", $match[2], $result);
            return $result;
        }, $text);
    }

}
