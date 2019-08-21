<?php

namespace Informer\Push;

use DateTime;
use Informer\Enums\OSType;
use Informer\Push\Android\Push as AndroidPush;
use Informer\Push\IOS\Push as IOSPush;
use const PUSH_FEEDBACK;
use const PUSH_NOTIFICATIONS;

class Push {

    private $iosPush;
    private $androidPush;
    private $feedbackTokens;

    function __construct() {
        $this->iosPush = new IOSPush();
        $this->androidPush = new AndroidPush();

        $this->feedbackTokens = array();
    }

    public function process($messages) {
        if (PUSH_NOTIFICATIONS) {
            // Notifications
            foreach ($messages as $message) {

                $text = $this->prepareText($message->getText());

                switch ($message->getOsType()) {
                    case OSType::ANDROID:
                        $this->androidPush->processNotification($text, $message->getData(), $message->getTokens());
                        break;

                    case OSType::IOS:
                        $this->iosPush->processNotification($text, $message->getData(), $message->getTokens());
                        break;
                }
            }
        }

        if (PUSH_FEEDBACK) {
            // Token drop
            $this->feedbackTokens[OSType::ANDROID] = $this->androidPush->processFeedback();
            $this->feedbackTokens[OSType::IOS] = $this->iosPush->processFeedback();
        }

        $this->iosPush->finish();
        $this->androidPush->finish();
    }

    public function getFeedbackTokens() {
        return $this->feedbackTokens;
    }

    private function prepareText($text) {
        $max = 100;
        
        $pos = mb_strpos($text, ".");

        if ($pos < $max - 3) {
            $text = mb_substr($text, 0, $pos);
        }

        if (mb_strlen($text) > $max) {
            $text = mb_substr($text, 0, $max - 3) . "...";
        }

        return $text;
    }

}
