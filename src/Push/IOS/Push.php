<?php

namespace Informer\Push\IOS;

use Wrep\Notificato\Notificato;
use const IOS_CERT_PASS;
use const IOS_CONFIG_DIR;

class Push {

    private $started;
    private $notificato;
    private $sent;

    function __construct() {
        $this->started = false;
        $this->sent = false;
    }

    private function start() {
        $this->notificato = new Notificato(IOS_CONFIG_DIR . '/certificate.pem', IOS_CERT_PASS);
        $this->sent = true;

        $this->started = true;
    }

    public function finish() {
        if ($this->started) {
            $this->notificato = null;
            $this->sent = false;
            $this->started = false;
        }
    }

    public function processNotification($text, $payload, $tokens) {
        if (!$this->started) {
            $this->start();
        }
        
        $data = array('payload' => $payload);
        
        foreach ($tokens as $token) {
            $msg = $this->notificato->messageBuilder()
                    ->setDeviceToken($token)
                    ->setAlert($text)
                    ->setBadge(1)
                    ->setSound()
                    ->setPayload($data)
                    ->setContentAvailable(true)
                    ->build();

            $this->notificato->send($msg);
        }
    }

    public function processFeedback() {
        if (!$this->sent) {
            return;
        }

        $tuples = $this->notificato->receiveFeedback();
        $tokens = array();

        foreach ($tuples as $tuple) {
            array_push($tokens, $tuple->getDeviceToken());
        }

        return $tokens;
    }

}
