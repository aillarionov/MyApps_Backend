<?php

namespace Informer\Callback\VK;

use Informer\Callback\Common\CommonCallback;
use Informer\Entities\VKConfirmation;

class Confirmation extends CommonCallback {

    public function __construct() {
    }

    public function execute($data) {
        $groupId = isset($data["group_id"]) ? $data["group_id"] : null;
        
        if (!$groupId) {
            throw new Exception("groupId", 1001);
        }
        
        $vkconfirmation = static::getEm()->getRepository(VKConfirmation::class)->findOneBy(array("groupId" => $groupId));
        if (!$vkconfirmation) {
            throw new Exception("No confirmation found", 2001);
        }
        $vkconfirmation->update();
        
        return $vkconfirmation->getConfirmation();
    }

}
