<?php

namespace Informer\DTO\Client;

use DateTime;
use Informer\Converter\Client\TextConverter;
use Informer\Entities\Item;
use Informer\Proxy\Client\CatalogMemberProxy;
use function mb_strpos;
use function mb_substr;

class CatalogMemberDTO {

    private static $trimSource = " \t\n\r";
    
    public static function modelToProxy(Item $model): CatalogMemberProxy {
        $text = $model->getRaw();

        $name = static::parseName($text);
        $stand = static::parseSingleParam("Стенд", $text);

        $categories = array_merge(static::parseArrayParam("Тематика", $text), static::parseArrayParam("Категория", $text));

        $phones = static::parseArrayParam("Телефон", $text);
        $emails = static::parseArrayParam("Почта", $text);
        $sites = static::parseArrayParam("Сайт", $text);
        $vks = static::parseArrayParam("ВКонтакте", $text);
        $fbs = static::parseArrayParam("Фейсбук", $text);
        $insts = static::parseArrayParam("Инстаграм", $text);


        $text = str_replace('Контакты:', '', $text);
        $text = trim($text);
        $text = TextConverter::textToHTML($text, $model->getSource());
        $date = $model->getDate()->format(DateTime::ISO8601);
        
        $pictures = array();
        foreach ($model->getPictures() as $picture) {
            array_push($pictures, PictureDTO::modelToProxy($picture));
        }

        return new CatalogMemberProxy(
            $model->getId(), $text, $date, $pictures, $model->getRaw(), $name, $stand, $categories, $phones, $emails, $sites, $vks, $fbs, $insts
        );
    }

    private static function parseName(&$text) {
        $pos = mb_strpos($text, "\n");
        if ($pos !== FALSE) {
            $data = mb_substr($text, 0, $pos);
            $text = mb_substr($text, $pos + 1);
            $text = trim($text, static::$trimSource);
            return trim($data, static::$trimSource);
        } else {
            $data = $text;
            $text = '';
            return trim($data, static::$trimSource);
        }
    }

    private static function parseArrayParam($param, &$text) {
        $result = array();

        $text = preg_replace_callback('/^' . $param . ':(.+)/imu', function ($match) use (&$result) {
            $data = trim($match[1], static::$trimSource);

            if (strpos($data, ',') !== FALSE) {
                $result = array_merge($result, explode(',', $data));
            } else {
                array_push($result, $data);
            }

            return '';
        }, $text);

        return $result;
    }

    private static function parseSingleParam($param, &$text) {
        $result = null;

        $text = preg_replace_callback('/^' . $param . ':(.+)/imu', function ($match) use (&$result) {
            $data = trim($match[1], static::$trimSource);

            $result = $data;

            return '';
        }, $text);

        return $result;
    }

}
