<?php

require_once "../../app/kernel.php";
if (!Admin::isLogged()) {
    header("location: login.php");
    exit;
}

header('Location: ' . $global['website_root'] . 'admin');

$object = new stdClass();

if (empty($_POST['email']) || empty($_POST['mode'])){
    $object->error = "Email or mode is empty!";

} else {
    if ($_POST['mode'] == "new") {
        $params = [
            ':email' => $_POST['email']
        ];
        $sql = "INSERT INTO emails (body) VALUES (:email)";
        $res = $global['pdo']->prepare($sql);
        $res->execute($params);

        //update subscribe status for new email
        $sql = "UPDATE subscribes SET notice_delivered = NULL";
        $res = $global['pdo']->prepare($sql);
        $res->execute();
    } else {
        $params = [
            ':email' => $_POST['email']
        ];
        $sql = "UPDATE emails SET body = :email WHERE is_greeting = 1";
        $res = $global['pdo']->prepare($sql);
        $res->execute($params);
    }

    $object->success = 1;
}
echo json_encode($object);