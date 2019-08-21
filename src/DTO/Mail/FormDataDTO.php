<?php

namespace Informer\DTO\Mail;

use Informer\Entities\FormData;
use Informer\Utils\Log;
use PHPMailer\PHPMailer\PHPMailer;

class FormDataDTO extends CommonDTO {

    public static function modelToMail(FormData $formData): PHPMailer {
        $mail = static::prepareMailer($formData->getForm()->getOrg());

        $message = '';
        foreach ($formData->getData() as $formItemData) {
            $value = $formItemData->getValue();
            $preparedValue = str_replace("\n", "<br>", $value);
            $message .= "<b>" . $formItemData->getFormItem()->getTitle() . "</b>: " . $preparedValue . "<br>";
        }

        // Recipient
        foreach (explode(",", $formData->getForm()->getDataEmail()) as $recipient) {
            $mail->addAddress(trim($recipient));
        }

        //Content
        $mail->isHTML(true);
        $mail->Subject = $formData->getForm()->getOrg()->getName() . ' \ ' . $formData->getForm()->getName();
        $mail->Body = $message;


        Log::write('MAIL', 'form', $formData->getForm()->getId(), $message);

        return $mail;
    }

}
