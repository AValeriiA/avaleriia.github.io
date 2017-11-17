<?php

require_once "../../app/kernel.php";

$object = new stdClass();

if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])){
    $object->error = "Name, Email and Text can not be blank";

} else {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $object->error = "Incorrect email format";

    } else {
        //save request to DB
        $sql = "INSERT INTO contacts (name, email, text) VALUES ('".htmlspecialchars($_POST['name'])."', '".$_POST['email']."', '".htmlspecialchars($_POST['message'])."')";
        $res = $global['pdo']->query($sql);

        //create email body
        $html = "<p><b>Name: </b>".htmlspecialchars($_POST['name'])."</p>";
        $html .= "<p><b>Email: </b>".$_POST['email']."</p>";
        $html .= "<p><b>Message: </b>".nl2br(htmlspecialchars($_POST['message']))."</p>";

        //send email
        $mailer = new Mailer();
        $object->success = $mailer->send($global['support_email'], "You have a new contact!", $html);
    }
}
echo json_encode($object);