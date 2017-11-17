<?php

require_once "../../app/kernel.php";

$object = new stdClass();

if (empty($_POST['email'])){
    $object->error = "Email can not be blank";

} else {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $object->error = "Incorrect email format";

    } else {
        $sql = "SELECT * FROM subscribes WHERE email = '".addslashes($_POST['email'])."' LIMIT 1";
        $res = $global['pdo']->query($sql);
        $exist_email = $res->fetch_assoc();

        if ($exist_email) {
            $object->error = "Email already exists";

        } else {
            //save inactive subscribe to DB
            $code = hash("sha256",$_POST['email']."X12_dtyR");
            $sql = "INSERT INTO subscribes (email, code, active) VALUES ('".addslashes($_POST['email'])."', '".$code."', 0)";
            $object->success = $global['pdo']->query($sql);

            $subLink = $global['website_root']."api/addSubscribe.php?e=".$_POST['email']."&c=".$code;
            //create email body
            $sql = "SELECT * FROM emails WHERE is_greeting = 1 ORDER BY created DESC LIMIT 1";
            $res = $global['pdo']->query($sql);
            $currentGreeting = $res->fetch_assoc();

            $html = $currentGreeting['body'];
            $html .= "<a href='".$subLink."'>Subscribe to ".$global['website_root']."</a>";

            //send email
            $mailer = new Mailer($global['smtp_mailer']);
            $object->success = $mailer->send($_POST['email'], "Confirm your subscription to ".$global['website_root'], $html);
        }
    }
}
echo json_encode($object);