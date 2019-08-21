<?php

namespace Informer\Callback\VK;

use Exception;
use Informer\Callback\Common\CommonCallback;
use Informer\Entities\Catalog;
use Informer\Entities\Notification;
use Informer\Entities\NotificationOrg;
use Informer\Enums\CatalogType;
use Informer\Enums\Source;
use Informer\Service\CatalogService;
use const PUSH_NOTIFICATION_TEXT_DELIMITER;
use function mb_strlen;
use function mb_strpos;
use function mb_substr;

class VKNotification extends CommonCallback {

    public function __construct() {
        
    }

    public function execute($data) {
        $groupId = isset($data["group_id"]) ? intval($data["group_id"]) : null;

        $object = isset($data['object']) ? $data['object'] : null;
        $itemId = isset($object['id']) ? intval($object['id']) : null;
        $text = isset($object['text']) ? $object['text'] : "";
        $message = $text;

        if (!$groupId) {
            throw new Exception("groupId", 1001);
        }

        if (!$itemId) {
            throw new Exception("itemId", 1001);
        }

        $pos = mb_strpos($message, PUSH_NOTIFICATION_TEXT_DELIMITER);

        if ($pos !== FALSE && $pos < 500 - 3) {
            $message = mb_substr($message, 0, $pos);
        }

        if (mb_strlen($message) > 500) {
            $message = mb_substr($message, 0, 500 - 3) . "...";
        }


        $catalogs = static::getEm()->getRepository(Catalog::class)->findBy(array(
            "source" => Source::VK,
            "type" => CatalogType::NEWS,
            "sourceOwner" => -$groupId
        ));

        $updatingCatalogs = array();
        $notification = new Notification();
        $notification->setText($message);


        // TODO: Change to separate notification for each org
        $orgId = 0;
        foreach ($catalogs as $catalog) {
            $orgId = $catalog->getOrg()->getId();
        }
        $news = array('orgId' => $orgId, 'itemId' => $itemId);

        // Поиск обновляемых каталогов
        $addedOrgs = array();

        foreach ($catalogs as $catalog) {
            $visitor = $catalog->getVisitorVisible() && (!$catalog->getVisitorNotificationFilter() || preg_match($catalog->getVisitorNotificationFilter(), $text));
            $presenter = $catalog->getPresenterVisible() && (!$catalog->getPresenterNotificationFilter() || preg_match($catalog->getPresenterNotificationFilter(), $text));

            if (($visitor || $presenter) && $catalog->getSourceAlbum() != 'fixedPost') {
                array_push($updatingCatalogs, $catalog);


                if (!in_array($catalog->getOrg(), $addedOrgs)) {
                    $notificationOrg = new NotificationOrg();
                    $notificationOrg->setOrg($catalog->getOrg());
                    $notificationOrg->setNotification($notification);
                    $notificationOrg->setForVisitor($visitor);
                    $notificationOrg->setForPresenter($presenter);
                    $notification->addNotificationOrg($notificationOrg);

                    array_push($addedOrgs, $catalog->getOrg());
                }

                $news['catalogId'] = $catalog->getId();
            }
        }

        $notification->setData(json_encode(array('news' => $news)));


        if (!$notification->getNotificationOrgs()->isEmpty()) {
            static::getEm()->persist($notification);
            static::getEm()->flush();
        }

        // Очистка кеша каталогов
        if ($updatingCatalogs) {
            foreach ($updatingCatalogs as $catalog) {
                CatalogService::clearCatalogCache($catalog);
            }
        }

        return "ok";
    }

}
