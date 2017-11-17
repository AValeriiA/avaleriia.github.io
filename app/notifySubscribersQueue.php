<?php
if (!defined(__DIR__)) {
    define(__DIR__, dirname(__FILE__));
}

require_once __DIR__."/kernel.php";

set_time_limit(14400);

$sql = "SELECT * FROM emails WHERE is_greeting = 0 ORDER BY created DESC LIMIT 1";
$res = $global['pdo']->query($sql);
$currentEmail = $res->fetch_assoc();

if (!$currentEmail['queued']) {
    //set email to queued (only one queue can work on email)
    $sql = "UPDATE emails SET queued = 1 WHERE id = ".$currentEmail['id'];
    $res = $global['pdo']->query($sql);

    //get subscribers
    $sql = "SELECT * FROM subscribes WHERE notice_delivered is NULL AND active = 1 AND created < '".$currentEmail['created']."' LIMIT 20";//sending via google smtp allow to 500email per one day
    $res = $global['pdo']->query($sql);
    while ($row = $res->fetch_assoc()) {
        $subscribers[] = $row;
    }

    foreach ($subscribers as $subscribe) {
        $unsubLink = $global['website_root']."api/unSubscribe.php?e=".$subscribe['email']."&c=".$subscribe['code'];

        //create email body
        $html = $currentEmail['body'];
        $html .= "<br><p>If you want to unsubscribe then click the link below:</p>";
        $html .= "<a href='".$unsubLink."'>Unsubscribe from ".$global['website_root']."</a>";

        //send email
        $mailer = new Mailer($global['smtp_mailer']);
        $sent = $mailer->send($subscribe['email'], "New from ".$global['website_root'], $html);

        //save result
        $sql = "UPDATE subscribes SET notice_delivered = ".(int)$sent." WHERE id = ".$subscribe['id'];
        $global['pdo']->query($sql);

        //unset email queued
        $sql = "UPDATE emails SET queued = 0 WHERE id = ".$currentEmail['id'];
        $global['pdo']->query($sql);
    }
}