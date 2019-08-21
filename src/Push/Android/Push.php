<?php

namespace Informer\Push\Android;

use GuzzleHttp\Client;
use sngrl\PhpFirebaseCloudMessaging\Client as Client2;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Notification;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use const ANDROID_API_ACCESS_KEY;

class Push {

    private $started;
    private $client;
    private $feedbackTokens;

    function __construct() {
        $this->started = false;
        $this->feedbackTokens = array();
    }

    private function start() {
        $this->client = new Client2();
        $this->client->setApiKey(ANDROID_API_ACCESS_KEY);
        $this->client->injectGuzzleHttpClient(new Client());


        $this->started = true;
    }

    public function finish() {
        if ($this->started) {
            $this->client = null;
            $this->started = false;
        }
    }

    public function processNotification($text, $data, $tokens) {
        if (!$tokens) {
            return;
        }

        if (!$this->started) {
            $this->start();
        }

        $message = new Message();
        $message->setPriority('high');
        $message->setNotification(new Notification($body = $text));
        $messageData = array('payload' => \json_decode($data, true), 'silent' => false);
        $message->setData($messageData);


        foreach ($tokens as $token) {
            $message->addRecipient(new Device($token));
        }
        
        
        $response = $this->client->send($message);
        $this->parseResponse($tokens, $response);
    }

    public function processFeedback() {
        return $this->feedbackTokens;
    }

    private function parseResponse($tokens, $response) {
        $i = 0;

        if ($response->getStatusCode() == 200) {
            $contents = $response->getBody()->getContents();

            $data = \json_decode($contents, true);

            foreach ($data['results'] as $result) {
                $this->parseResult($result, $tokens[$i]);
                $i++;
            }
        }
    }

    private function parseResult($result, $token) {
        
        if (isset($result['error'])) {
            switch ($result['error']) {
                case "InvalidRegistration":
                case "NotRegistered":
                    array_push($this->feedbackTokens, $token);
                    break;
            }
        }
    }

}
