<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SMTPMailer {
    private $PHPMailer;

    public function __construct() {
        global $global;

        $mailer = new PHPMailer();
        $mailer->setFrom($global['support_email']);
        $mailer->isSMTP();
        $mailer->Host = getenv('SMTP_HOST');
        $mailer->SMTPAuth = true;
        $mailer->Username = getenv('SMTP_USER');
        $mailer->Password = getenv('SMTP_PASS');
        $mailer->SMTPSecure = 'ssl';
        $mailer->Port = getenv('SMTP_PORT');
        $mailer->CharSet = 'UTF-8';
        $mailer->isHTML(true);

        $this->PHPMailer = $mailer;
    }

    public function send($mail_to, $subject, $body) {
        $this->PHPMailer->addAddress($mail_to);
        $this->PHPMailer->Subject = $subject;
        $this->PHPMailer->Body = $body;

        return $this->PHPMailer->send();
    }
}