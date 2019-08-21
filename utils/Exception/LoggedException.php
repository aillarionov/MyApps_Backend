<?php

use PHPMailer\PHPMailer\PHPMailer;

class LoggedException extends Exception {

    public function __construct($message, $code = 0, $previous = null) {
        
        if (!is_dir(EXCEPTIONS_LOGS_DIR)) {
            mkdir(EXCEPTIONS_LOGS_DIR, DIR_PERMISSION, true);
        }

        parent::__construct($message, $code, $previous);

        $this->log();
        $this->mail();
    }

    protected function getPayload(){
        return null;
    }
    
    private function log() {
        $i = 0;
        $fileName = null;
        while (!$fileName || file_exists($fileName)) {
            $fileName = EXCEPTIONS_LOGS_DIR . '/' . date('Y_m_d_H_i_s_') . ($i++) . '.json';
        }

        $data = array(
            'code' => $this->code,
            'message' => $this->message,
            'payload' => $this->getPayload(),
            'environment' => array(
                '$_GET' => $_GET,
                '$_POST' => $_POST,
                '$_SEVER' => $_SERVER
            )
        );

        file_put_contents($fileName, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    private function mail() {
        $fileName = LOGS_DIR . '/exception_sent';
        if (DEBUG_EMAIL && !file_exists($fileName)) {
            $this->send(DEBUG_EMAIL, "Произошло исключение в приложении " . APP_NAME, $this->message);
            file_put_contents($fileName, DEBUG_EMAIL . ' ' . date('Y_m_d_H_i_s'));
        }
    }
    
    public function send($to, $subject, $message) {
        try {
            //mail($to, $subject, $message);
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
            $mail->setFrom(SMTP_MAIL_FROM, 'Mail robot');
            $mail->addAddress($to);

            //Content
            $mail->isHTML(false);
            
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
        } catch (Exception $e) {
            throw new LoggedException($e->getMessage(), $e->getCode());
        }
    }

}
