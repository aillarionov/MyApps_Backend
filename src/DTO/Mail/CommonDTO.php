<?php

namespace Informer\DTO\Mail;

use Informer\Entities\Org;
use PHPMailer\PHPMailer\PHPMailer;
use const SMTP_MAIL_FROM;
use const SMTP_MAIL_HOST;
use const SMTP_MAIL_PASSWORD;
use const SMTP_MAIL_PORT;
use const SMTP_MAIL_SECURE;
use const SMTP_MAIL_USER;

class CommonDTO {

    protected static function prepareMailer(Org $org): PHPMailer {
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";

        $mail->isSMTP();
        $mail->Host = SMTP_MAIL_HOST;
        $mail->Port = SMTP_MAIL_PORT;
        $mail->Username = SMTP_MAIL_USER;
        $mail->Password = SMTP_MAIL_PASSWORD;
        $mail->SMTPSecure = SMTP_MAIL_SECURE;   // ssl, tls                          
        $mail->SMTPAuth = true;

        //Recipients
        $mail->setFrom(SMTP_MAIL_FROM, 'Form mail robot');


        return $mail;
    }

}
