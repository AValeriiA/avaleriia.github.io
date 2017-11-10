<?php
require_once "../../vendor/autoload.php";
require_once "../../app/models/SMTPMailer.php";

require_once "../../app/kernel.php";

header('Location: ' . $global['website_root']);

$object = new stdClass();

if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])){
    $object->error = "Name, Email and Text can not be blank";

} else {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $object->error = "Incorrect email format";

    } else {
        //save request to DB
        $params = [
            ':name' => htmlspecialchars($_POST['name']),
            ':email' => $_POST['email'],
            ':text' => htmlspecialchars($_POST['message'])
        ];
        $sql = "INSERT INTO contacts (name, email, text) VALUES (:name, :email, :text)";

        $res = $global['pdo']->prepare($sql);
        $res->execute($params);

        //create email body
        $html = "<p><b>Name: </b>".htmlspecialchars($_POST['name'])."</p>";
        $html .= "<p><b>Email: </b>".$_POST['email']."</p>";
        $html .= "<p><b>Message: </b>".nl2br(htmlspecialchars($_POST['message']))."</p>";

        //send email
        $mailer = new SMTPMailer();
        $object->success = $mailer->send($global['support_email'], "You have a new contact!", $html);
    }
}
echo json_encode($object);