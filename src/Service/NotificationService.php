<?php

namespace Informer\Service;

use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Query;
use Informer\Entities\ClientToken;
use Informer\Entities\Notification;
use Informer\Enums\OSType;
use Informer\Proxy\Push\Message;
use Informer\Push\Push;

class NotificationService extends CommonService {

    public static function sendNotifications() {

        $nots = static::getMessagesArray();

        $messages = array();

        foreach ($nots as $not) {
            foreach ($not['items'] as $ostype => $tokens) {
                
                
                
                array_push($messages, new Message($not['text'], $not['data'], new OSType($ostype), $tokens));
            }
        }

        $notifications = array_keys($nots);
        
        // Send pushes
        $push = new Push();
        $push->process($messages);

        // Remove not actual tokens
        foreach ($push->getFeedbackTokens() as $osType => $feedbackTokens) {
            if ($feedbackTokens) {
                static::deleteTokens($osType, $feedbackTokens);
            }
        } 

        // Update notifications
        if ($notifications) {
            static::setNoficationSent($notifications);
        }
    }

    public static function deleteTokens($osType, $tokens) {
        $qb = static::getEm()->createQueryBuilder();
        $q = $qb->delete(ClientToken::class, 'c')
                ->where('c.tokenId IN (?1)')
                ->andWhere('c.osType = ?2')
                ->setParameter(1, $tokens, Connection::PARAM_STR_ARRAY)
                ->setParameter(2, $osType);
        $p = $q->getQuery()->execute();
    }

    protected static function getMessagesArray() {
        $qb = static::getEm()->createQueryBuilder();

        $qb->select(array('n.id as n_id', 'n.text', 'n.data', 'ct.osType', 'ct.tokenId'))
                ->from(Notification::class, 'n')
                ->innerJoin('n.notificationOrgs', 'no')
                ->innerJoin('no.org', 'o')
                ->innerJoin('o.clientTokenOrgs', 'cto', 'WITH', 'cto.receiveNotifications = TRUE '
                        . 'AND ((cto.isVisitor = TRUE AND no.forVisitor = TRUE) OR (cto.isPresenter = TRUE AND no.forPresenter = TRUE))')
                ->innerJoin('cto.clientToken', 'ct')
                ->where('n.sent IS NULL')
                ->groupBy('n.id, n.text, n.data, ct.osType, ct.tokenId')
                ->orderBy("n.id, ct.osType");

        $items = $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);



        $nots = array();

        foreach ($items as $item) {
            // id
            if (!array_key_exists($item['n_id'], $nots)) {
                $nots[$item['n_id']] = array("text" => $item['text'], "data" => $item['data'], "items" => array());
            }
            $msgItems = &$nots[$item['n_id']]['items'];

            // osType
            $osTypeName = $item['osType']->getValue();
            if (!array_key_exists($osTypeName, $msgItems)) {
                $msgItems[$osTypeName] = array();
            }
            $msgos = &$msgItems[$osTypeName];

            //tokenId
            if (!in_array($item['tokenId'], $msgos)) {
                array_push($msgos, $item['tokenId']);
            }
        }

        return $nots;
    }

    protected static function setNoficationSent($notifications) {
        $qb = static::getEm()->createQueryBuilder();
        $q = $qb->update(Notification::class, 'n')
                ->set('n.sent', '?1')
                ->where('n.id IN (?2)')
                ->setParameter(1, new DateTime())
                ->setParameter(2, $notifications, Connection::PARAM_INT_ARRAY);
        $p = $q->getQuery()->execute();
    }

}
