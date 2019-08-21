<?php

namespace Informer\Callback\VK;

use Exception;
use const VK_PRIVATEKEY;

class Parser {

    public function parse($data) {
        $type = isset($data["type"]) ? $data["type"] : "";
        $incomeKey = isset($data["secret"]) ? $data["secret"] : null;


//        if ($incomeKey != VK_PRIVATEKEY) {
//            throw new Exception("Data corrupted", 3000);
//        }

        $result = null;

        switch ($type) {
            case 'confirmation':
                $callback = new Confirmation();
                $result = $callback->execute($data);
                break;

            case 'photo_new':
            case 'video_new':
                $callback = new Update();
                $result = $callback->execute($data);
                break;

            case 'wall_post_new':
                $callback = new VKNotification();
                $result = $callback->execute($data);
                break;

            default:
                return null;
        }

        return $result;
    }

}
