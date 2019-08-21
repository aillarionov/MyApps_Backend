<?php

namespace Informer\DTO\Mail;

use Informer\Entities\CallbackData;
use Informer\Entities\Org;
use Informer\Utils\Log;
use PHPMailer\PHPMailer\PHPMailer;
use const CALLBACK_EMAIL;

class CallbackDataDTO extends CommonDTO {

    public static function modelToMail(CallbackData $callbackData): PHPMailer {
        $mail = static::prepareMailer(new Org());

        $message = '';
        $message .= '<b>Email:</b> ' . $callbackData->getEmail() . '<br>';
        $message .= '<b>Телефон:</b> ' . $callbackData->getPhone() . '<br>';
        $message .= '<b>Содержимое:</b> <br>';
        $message .= str_replace("\n", "<br>", $callbackData->getSubject());

        // Recipient
        $mail->addAddress(CALLBACK_EMAIL);

        //Content
        $mail->isHTML(true);
        $mail->Subject = "Запрос из приложения";
        $mail->Body = $message;

        Log::write('MAIL', 'callback', 0, $message);

        return $mail;
    }

}
