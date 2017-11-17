<?php
define(__DIR__, dirname(__FILE__));

require_once "../../vendor/autoload.php";
require_once "../../app/models/Mailer.php";

require_once "../../app/kernel.php";

$object = new stdClass();

if (empty($_POST['email'])){
    $object->error = "Email can not be blank";

} else {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $object->error = "Incorrect email format";

    } else {
        $params = array(':email' => $_POST['email']);
        $sql = "SELECT * FROM subscribes WHERE email = :email LIMIT 1";

        $res = $global['pdo']->prepare($sql);
        $res->execute($params);

        $exist_email = $res->fetch(PDO::FETCH_ASSOC);

        if ($exist_email) {
            $object->error = "Email already exists";

        } else {
            //save inactive subscribe to DB
            $code = password_hash($_POST['email']."X12_dtyR", PASSWORD_BCRYPT);
            $params = array(
                ':email' => $_POST['email'],
                ':code' => $code
            );
            $sql = "INSERT INTO subscribes (email, code, active) VALUES (:email, :code, 0)";

            $res = $global['pdo']->prepare($sql);
            $object->success = $res->execute($params);

            $subLink = $global['website_root']."api/addSubscribe.php?e=".$_POST['email']."&c=".$code;
            //create email body
            $sql = "SELECT * FROM emails WHERE is_greeting = 1 ORDER BY created DESC LIMIT 1";
            $res = $global['pdo']->prepare($sql);
            $res->execute();
            $currentGreeting = $res->fetch(PDO::FETCH_ASSOC);

            $html = $currentGreeting['body'];
            $html .= "<a href='".$subLink."'>Subscribe to ".$global['website_root']."</a>";

            //send email
            $mailer = new Mailer($global['smtp_mailer']);
            $object->success = $mailer->send($_POST['email'], "Confirm your subscription to ".$global['website_root'], $html);
        }
    }
}
echo json_encode($object);