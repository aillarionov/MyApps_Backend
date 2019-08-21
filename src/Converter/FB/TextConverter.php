<?php

namespace Informer\Converter\FB;

class TextConverter {

      public static function convertHashToLink(&$text) {
        $text = preg_replace_callback("/\#([\w\d]+)/ui", function ($match) {
            $result = str_replace("{text}", $match[0], FB_HASH_TEMPLATE);
            $result = str_replace("{hash}", $match[1], $result);
            return $result;
        }, $text);
    }

    public static function convertGroupToLink(&$text) {
        $text = preg_replace_callback("/\[([\w\d]+)\|([^\]]+)\]/ui", function ($match)  {
            $result = str_replace("{text}", $match[0], FB_GROUP_TEMPLATE);
            $result = str_replace("{id}", $match[1], $result);
            $result = str_replace("{name}", $match[2], $result);
            return $result;
        }, $text);
    }

}
