<?php

namespace Informer\Converter\Client;

use Informer\Converter\FB\TextConverter as FBTextConverter;
use Informer\Converter\VK\TextConverter as VKTextConverter;
use Informer\Enums\Source;
use const LINK_TEMPLATE;

class TextConverter {

    private static $trimSource = " \t\n\r";

    public static function textToHTML($text, $source) {
        $result = $text;

        switch ($source) {
            case Source::FB:
                FBTextConverter::convertHashToLink($result);
                break;

            case Source::VK:
                VKTextConverter::convertGroupToLink($result);
                VKTextConverter::convertHashToLink($result);
                break;
        }

        static::generateTextLinks($result);
        static::generateBR($result);

        return $result;
    }

    protected static function generateTextLinks(&$text) {
        $text = preg_replace_callback("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#ui", function ($match) {
            
            $orig = $match['0'];
            $url = trim($orig, static::$trimSource);
            $href = $url;
            if (mb_substr($href, 0, 4) != 'http') {
                $href = 'http://' . $href;
            }

            $link = str_replace('{url}', $href, LINK_TEMPLATE);
            $link = str_replace('{title}', $url, $link);

            $result = str_replace($url, $link, $orig);

            return $result;
        }, $text);
    }

    protected static function generateBR(&$text) {
        $text = str_replace("\n", "<br />", $text);
    }

}
