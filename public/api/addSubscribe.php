<?php
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
        $params = [':email' => $_POST['email']];
        $sql = "SELECT * FROM subscribes WHERE email = :email LIMIT 1";

        $res = $global['pdo']->prepare($sql);
        $res->execute($params);

        $exist_email = $res->fetch(PDO::FETCH_ASSOC);

        if ($exist_email) {
            $object->error = "Email already exists";

        } else {
            //save subscribe to DB
            $code = password_hash($_POST['email'], PASSWORD_BCRYPT);
            $params = [
                ':email' => $_POST['email'],
                ':code' => $code
            ];
            $sql = "INSERT INTO subscribes (email, code) VALUES (:email, :code)";

            $res = $global['pdo']->prepare($sql);
            $object->success = $res->execute($params);

            //create email body
            $sql = "SELECT * FROM emails WHERE is_greeting = 1 ORDER BY created DESC LIMIT 1";
            $res = $global['pdo']->prepare($sql);
            $res->execute();
            $currentGreeting = $res->fetch(PDO::FETCH_ASSOC);

            $unsubLink = $global['website_root']."api/unSubscribe.php?e=".$_POST['email']."&c=".$code;

            $html = $currentGreeting['body'];
            $html .= "<p>If you want to unsubscribe then click the link below:</p>";
            $html .= "<a href='".$unsubLink."'>Unsubscribe from ".$global['website_root']."</a>";

            //send email
            $mailer = new Mailer($global['smtp_mailer']);
            $object->success = $mailer->send($_POST['email'], "You subscribed to ".$global['website_root']."!", $html, $unsubLink);
        }
    }
}
echo json_encode($object);