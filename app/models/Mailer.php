<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $PHPMailer;

    public function __construct($isSMTP = true) {
        global $global;

        $mailer = new PHPMailer();
        if ($isSMTP) {
            //send via SMTP
            $mailer->isSMTP();
            $mailer->Host = $global['smtp_host'];
            $mailer->SMTPAuth = true;
            $mailer->Username = $global['smtp_user'];
            $mailer->Password = $global['smtp_pass'];
            $mailer->SMTPSecure = 'ssl';
            $mailer->Port = $global['smtp_port'];
        } else {
            //send via standard PHP mail()
            $mailer->isMail();
        }
        $mailer->setFrom($global['support_email']);
        $mailer->CharSet = 'UTF-8';
        $mailer->isHTML(true);

        $this->PHPMailer = $mailer;
    }

    public function send($mail_to, $subject, $body, $unsubLink = false) {
        $this->PHPMailer->addAddress($mail_to);
        $this->PHPMailer->Subject = $subject;
        $this->PHPMailer->Body = $body;
        if ($unsubLink) {
            $this->PHPMailer->addCustomHeader('List-Unsubscribe', '<'.$unsubLink.'>');
            $this->PHPMailer->addCustomHeader('Precedence', 'bulk');
        }

        return $this->PHPMailer->send();
    }
}