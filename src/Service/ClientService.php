<?php

namespace Informer\Service;

use Informer\DTO\Mail\FormDataDTO;
use Informer\DTO\Mail\CallbackDataDTO;
use Informer\Entities\ClientAd;
use Informer\Entities\ClientToken;
use Informer\Entities\FormData;
use Informer\Entities\CallbackData;

class ClientService extends CommonService {

    public static function putClientToken(ClientToken $clientToken) {
        static::getEm()->persist($clientToken);
    }

    public static function putClientAd(ClientAd $clientAd) {
        static::getEm()->persist($clientAd);
    }

    public static function postForm(FormData $formData) {
        $mail = FormDataDTO::modelToMail($formData);

        if (SAVE_MAIL) {
            if (!is_dir(MAIL_LOGS_DIR)) {
                mkdir(MAIL_LOGS_DIR, DIR_PERMISSION, true);
            }

            $i = 0;
            $fileName = null;
            while (!$fileName || file_exists($fileName)) {
                $fileName = MAIL_LOGS_DIR . '/' . date('Y_m_d_H_i_s_') . ($formData->getForm()->getId()) . '_' . ($i++) . '.json';
            }

            file_put_contents($fileName, json_encode(array(
                'to' => $mail->getToAddresses(),
                'subject' => $mail->Subject,
                'message' => $mail->Body
                            ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        $mail->send();
    }
    
    public static function postCallback(CallbackData $callbackData) {
        $mail = CallbackDataDTO::modelToMail($callbackData);

        if (SAVE_MAIL) {
            if (!is_dir(MAIL_LOGS_DIR)) {
                mkdir(MAIL_LOGS_DIR, DIR_PERMISSION, true);
            }

            $i = 0;
            $fileName = null;
            while (!$fileName || file_exists($fileName)) {
                $fileName = MAIL_LOGS_DIR . '/' . date('Y_m_d_H_i_s_') . '_callback_' . ($i++) . '.json';
            }

            file_put_contents($fileName, json_encode(array(
                'to' => $mail->getToAddresses(),
                'subject' => $mail->Subject,
                'message' => $mail->Body
                            ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        $mail->send();
    }

}
