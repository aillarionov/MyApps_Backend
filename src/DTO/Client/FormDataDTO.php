<?php

namespace Informer\DTO\Client;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\Entities\Form;
use Informer\Entities\FormData;
use Informer\Entities\FormDataItem;

class FormDataDTO {

    protected static function getEm(): EntityManager {
        global $g_entityManager;
        return $g_entityManager;
    }

    public static function proxyToModel($proxy): FormData {
        if (empty($proxy['formId'])) {
            throw new Exception("formId", 1001);
        }

        $form = static::getEm()->find(Form::class, intval($proxy['formId']));
        if (!$form) {
            throw new Exception("Form [" . $proxy['formId'] . "] not found", 1002);
        }

        $proxyData = isset($proxy['data']) && is_array($proxy['data']) ? $proxy['data'] : array();



        $data = array();

        foreach ($form->getItems() as $formItem) {
            $found = false;

            foreach ($proxyData as $proxyItem) {

                if (isset($proxyItem['name']) && $proxyItem['name'] == $formItem->getName()) {
                    array_push($data, new FormDataItem($formItem, $proxyItem['value']));

                    $found = true;
                    break;
                }
            }

            if (!$found && $formItem->getRequired()) {
                throw new Exception("FormItem data [" . $formItem->getName() . "]", 1001);
            }
        }

        return new FormData($form, $data);
    }

}
